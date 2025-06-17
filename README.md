# ValueSuggestUpdater

Allows automatic update of [ValueSuggest](https://omeka.org/s/modules/ValueSuggest/) values.

Requires [ValueSuggest](https://omeka.org/s/modules/ValueSuggest/).

## Why ?

- Suggestions services may change their labels, making the labels stored in
  Omeka outdated
- ValueSuggest values may have been imported from a source that have incomplete
  labels, or no labels at all

Updating these values automatically allows to keep them up-to-date.

## Installation

See general end user documentation for [Installing a
module](http://omeka.org/s/docs/user-manual/modules/#installing-modules)

## Usage

When enabled, this module adds an item to the admin navigation menu ("Value
Suggest Updater").
Clicking on it will take you to a form where you can choose which data types
need to be updated. Only data types that support updates will be displayed
here.
The update will be done in a background job after you submit the form.

## Supported data types

- IdRef: All
- IdRef: Person names
- IdRef: Collectivities
- IdRef: Conferences
- IdRef: Subjects
- IdRef: Subjects Rameau
- IdRef: Subjects F-MeSH
- IdRef: Geography
- IdRef: Family names
- IdRef: Uniform titles
- IdRef: Authors-Titles
- IdRef: Trademarks
- IdRef: PPN id
- IdRef: Library registry (RCR)

If you want to add support for a data type, please open a pull request.

## Why is this not part of ValueSuggest ?

[A pull request](https://github.com/omeka-s-modules/ValueSuggest/pull/86) was
opened to try that first, but we agreed that it was better as a separate
module.

## License

ValueSuggestUpdater is distributed under the GNU General Public License version
3 (GPLv3).  The full text of this license is given in the `LICENSE` file.
