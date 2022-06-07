<?php

namespace Actengage\Capture\DataTypes;

enum WaitUntil: string
{
    case Load = 'load';
    case DomContentLoaded = 'domcontentloaded';
    case NetworkdIdle0 = 'networkidle0';
    case NetworkdIdle2 = 'networkidle2';
}