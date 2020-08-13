<?php

namespace Rafflex\AdminSetupXtension;

class App
{
    private static $instance;

    /**
     * Singleton constructor.
     *
     * @return \Rafflex\AdminSetupXtension\App
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     * Class constructor.
     */
    public function __construct()
    {
//        $this->acl = defined('S3_UPLOADS_OBJECT_ACL') ? S3_UPLOADS_OBJECT_ACL : 'public-read';
//        $this->local = defined('S3_UPLOADS_USE_LOCAL') ? S3_UPLOADS_USE_LOCAL : false;
//        $this->region = defined('S3_UPLOADS_REGION') ? S3_UPLOADS_REGION : null;
//        $this->bucket = defined('S3_UPLOADS_BUCKET') ? S3_UPLOADS_BUCKET : null;
//        $this->key = defined('S3_UPLOADS_KEY') ? S3_UPLOADS_KEY : null;
//        $this->secret = defined('S3_UPLOADS_SECRET') ? S3_UPLOADS_SECRET : null;
//        $this->endpoint = defined('S3_UPLOADS_ENDPOINT') ? S3_UPLOADS_ENDPOINT : null;
//        $this->signature = defined('S3_UPLOADS_SIGNATURE') ? S3_UPLOADS_SIGNATURE : 'v4';
//        $this->bucketPath = "s3://{$this->bucket}/app";
//        $this->bucketUrl = "https://{$this->bucket}.{$this->region}.cdn.digitaloceanspaces.com";
//        $this->editor = '\\TinyPixel\\Uploads\\ImageEditorImagick';
    }

    /**
     * Setup the hooks, urls filtering etc for S3 Uploads
     *
     * @return void
     */
    public function setup(): void
    {
//        $this->filterParameters();

//        add_filter('upload_dir', [$this, 'filterUploadDir']);
    }

    /**
     * Filter parameters
     *
     * @return void
     */
    public function filterParameters(): void
    {
//        $this->acl = apply_filters('s3_media_acl', $this->acl);
    }
}
