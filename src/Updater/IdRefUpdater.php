<?php

namespace ValueSuggestUpdater\Updater;

use Laminas\Http\Client as HttpClient;
use Laminas\Http\Request;
use Laminas\Log\Logger;
use Omeka\Entity\Value;

class IdRefUpdater implements UpdaterInterface
{
    protected HttpClient $httpClient;
    protected Logger $logger;
    protected int $maxTries = 3;

    public function __construct(HttpClient $httpClient, Logger $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function update(Value $value): bool
    {
        $logger = $this->logger;

        $uri = $value->getUri();
        if (!$uri) {
            $logger->warn(sprintf('IdRefUpdater: value does not have an URI (id: %d)', $value->getId()));
            return false;
        }

        $matches = [];
        if (!preg_match('~https?://www.idref.fr/([0-9X]{9})~', $uri, $matches)) {
            $logger->warn(sprintf('IdRefUpdater: value URI does not match typical IdRef URI (id: %d, uri: %s)', $value->getId(), $uri));
            return false;
        }

        $ppn = $matches[1];
        $solrUri = sprintf('https://www.idref.fr/Sru/Solr?wt=json&fl=affcourt_z&q=ppn_z:%s', urlencode($ppn));

        try {
            $response = $this->request($solrUri);
        } catch (\Exception $e) {
            $logger->warn(sprintf('IdRefUpdater: request to IdRef failed (uri: %s): %s', $solrUri, $e->getMessage()));
            return false;
        }

        $json = $response->getBody();
        $data = json_decode($json, true);
        if (!$data) {
            $logger->warn(sprintf('IdRefUpdater: failed to parse response as JSON: %s', json_last_error_msg()));
            return false;
        }

        $docs = $data['response']['docs'];
        if (empty($docs)) {
            $logger->warn(sprintf('IdRefUpdater: no record found for PPN "%s"', $ppn));
            return false;
        }

        $label = $docs[0]['affcourt_z'];
        if (!$label) {
            $logger->warn(sprintf('IdRefUpdater: record found for PPN "%s" has no "affcourt_z"', $ppn));
            return false;
        }

        if ($value->getValue() === $label) {
            // Nothing to update, do not log anything as it is the most common case.
            return false;
        }

        $logger->info(
            sprintf(
                'IdRefUpdater: value %d updated ("%s" -> "%s") for resource %d',
                $value->getId(),
                $value->getValue(),
                $label,
                $value->getResource()->getId()
            )
        );

        $value->setValue($label);

        return true;
    }

    protected function request(string $uri): \Laminas\Http\Response
    {
        $request = new Request();
        $request->setUri($uri);

        $tries = 0;
        do {
            $tries++;

            if ($tries > 1) {
                $sleepSeconds = ($tries - 1) * 30;
                $this->logger->info(sprintf('HTTP request failed (URL: %s): %s. Retrying in %d seconds', $uri, $response->renderStatusLine(), $sleepSeconds));
                sleep($sleepSeconds);
            }

            $response = $this->httpClient->send($request);
        } while (!$response->isOk() && $tries < $this->maxTries);

        if (!$response->isOk()) {
            throw new \Exception(sprintf('HTTP request failed (URL: %s): %s', $uri, $response->renderStatusLine()));
        }

        return $response;
    }
}
