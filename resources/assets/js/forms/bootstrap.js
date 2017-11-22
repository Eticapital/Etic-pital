/**
 * Load the Form helper class.
 */
require('./form');

/**
 * Define the ForError collection class.
 */
require('./errors');

/**
 * Add additional HTTP / form helpers to the App object.
 */
$.extend(App, require('./http'));
