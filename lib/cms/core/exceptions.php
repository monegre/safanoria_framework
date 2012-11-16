<?php
/**
 *
 */

/**
 * Base Exception class for all Safanoria CMS
 */
class CmsException extends Exception {}

/**
 * Thrown when a model is not valid
 */
class InvalidModelException extends CmsException {}

/**
 * Thrown when an error occurs changing the password
 */
class PasswordChangeException extends CmsException {}