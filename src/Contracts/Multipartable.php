<?php

namespace Actengage\Capture\Contracts;

use Actengage\Capture\DataTypes\MultipartData;

interface Multipartable
{
    /**
     * Cast to multipart data.
     *
     * @return \Actengage\Capture\DataTypes\MultipartData
     */
    public function toMultipart(): MultipartData;
}