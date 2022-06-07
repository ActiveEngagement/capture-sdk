<?php

namespace Actengage\Capture\DataTypes;

enum Encoding: string
{
    case Base64 = 'base64';
    case Binary = 'binary';
}