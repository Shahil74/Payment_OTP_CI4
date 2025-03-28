<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/firestore/admin/v1/firestore_admin.proto

namespace Google\Cloud\Firestore\Admin\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request for
 * [FirestoreAdmin.ListBackups][google.firestore.admin.v1.FirestoreAdmin.ListBackups].
 *
 * Generated from protobuf message <code>google.firestore.admin.v1.ListBackupsRequest</code>
 */
class ListBackupsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The location to list backups from.
     * Format is `projects/{project}/locations/{location}`.
     * Use `{location} = '-'` to list backups from all locations for the given
     * project. This allows listing backups from a single location or from all
     * locations.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * An expression that filters the list of returned backups.
     * A filter expression consists of a field name, a comparison operator, and a
     * value for filtering.
     * The value must be a string, a number, or a boolean. The comparison operator
     * must be one of: `<`, `>`, `<=`, `>=`, `!=`, `=`, or `:`.
     * Colon `:` is the contains operator. Filter rules are not case sensitive.
     * The following fields in the [Backup][google.firestore.admin.v1.Backup] are
     * eligible for filtering:
     *   * `database_uid` (supports `=` only)
     *
     * Generated from protobuf field <code>string filter = 2;</code>
     */
    private $filter = '';

    /**
     * @param string $parent Required. The location to list backups from.
     *
     *                       Format is `projects/{project}/locations/{location}`.
     *                       Use `{location} = '-'` to list backups from all locations for the given
     *                       project. This allows listing backups from a single location or from all
     *                       locations. Please see
     *                       {@see FirestoreAdminClient::locationName()} for help formatting this field.
     *
     * @return \Google\Cloud\Firestore\Admin\V1\ListBackupsRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The location to list backups from.
     *           Format is `projects/{project}/locations/{location}`.
     *           Use `{location} = '-'` to list backups from all locations for the given
     *           project. This allows listing backups from a single location or from all
     *           locations.
     *     @type string $filter
     *           An expression that filters the list of returned backups.
     *           A filter expression consists of a field name, a comparison operator, and a
     *           value for filtering.
     *           The value must be a string, a number, or a boolean. The comparison operator
     *           must be one of: `<`, `>`, `<=`, `>=`, `!=`, `=`, or `:`.
     *           Colon `:` is the contains operator. Filter rules are not case sensitive.
     *           The following fields in the [Backup][google.firestore.admin.v1.Backup] are
     *           eligible for filtering:
     *             * `database_uid` (supports `=` only)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Firestore\Admin\V1\FirestoreAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The location to list backups from.
     * Format is `projects/{project}/locations/{location}`.
     * Use `{location} = '-'` to list backups from all locations for the given
     * project. This allows listing backups from a single location or from all
     * locations.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The location to list backups from.
     * Format is `projects/{project}/locations/{location}`.
     * Use `{location} = '-'` to list backups from all locations for the given
     * project. This allows listing backups from a single location or from all
     * locations.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * An expression that filters the list of returned backups.
     * A filter expression consists of a field name, a comparison operator, and a
     * value for filtering.
     * The value must be a string, a number, or a boolean. The comparison operator
     * must be one of: `<`, `>`, `<=`, `>=`, `!=`, `=`, or `:`.
     * Colon `:` is the contains operator. Filter rules are not case sensitive.
     * The following fields in the [Backup][google.firestore.admin.v1.Backup] are
     * eligible for filtering:
     *   * `database_uid` (supports `=` only)
     *
     * Generated from protobuf field <code>string filter = 2;</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * An expression that filters the list of returned backups.
     * A filter expression consists of a field name, a comparison operator, and a
     * value for filtering.
     * The value must be a string, a number, or a boolean. The comparison operator
     * must be one of: `<`, `>`, `<=`, `>=`, `!=`, `=`, or `:`.
     * Colon `:` is the contains operator. Filter rules are not case sensitive.
     * The following fields in the [Backup][google.firestore.admin.v1.Backup] are
     * eligible for filtering:
     *   * `database_uid` (supports `=` only)
     *
     * Generated from protobuf field <code>string filter = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

}

