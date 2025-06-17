<?php
namespace ValueSuggestUpdater\Controller\Admin;

use ValueSuggestUpdater\Form\UpdateForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function updateAction()
    {
        $form = $this->getForm(UpdateForm::class);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();

                $this->jobDispatcher()->dispatch('ValueSuggestUpdater\Job\Update', [
                    'data_types' => $data['data_types'] ?? [],
                ]);

                $this->messenger()->addSuccess('Updating values. This may take a while.'); // @translate

                return $this->redirect()->toRoute('admin/value-suggest-updater');
            } else {
                $this->messenger()->addFormErrors($form);
            }
        }

        $view = new ViewModel;
        $view->setVariable('form', $form);

        return $view;
    }
}
