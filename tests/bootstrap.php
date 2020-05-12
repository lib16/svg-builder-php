<?php
require_once 'vendor/autoload.php';

// @todo for Travis CI
require_once 'vendor/lib16/utils/src/enums/css/Unit.php';
require_once 'vendor/lib16/utils/src/enums/css/LengthUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/Media.php';
require_once 'vendor/lib16/utils/src/enums/mime/MimeType.php';
require_once 'vendor/lib16/utils/src/enums/mime/StyleType.php';
require_once 'vendor/lib16/xml/src/Adhoc.php';
require_once 'vendor/lib16/xml/src/Attributes.php';
require_once 'vendor/lib16/xml/src/ProcessingInstruction.php';
require_once 'vendor/lib16/xml/src/Xml.php';
require_once 'vendor/lib16/xml/src/XmlWrapper.php';
require_once 'vendor/lib16/xml/src/shared/ClassAttribute.php';
require_once 'vendor/lib16/xml/src/shared/MediaAttribute.php';
require_once 'vendor/lib16/xml/src/shared/Space.php';
require_once 'vendor/lib16/xml/src/shared/Target.php';
require_once 'vendor/lib16/xml/src/shared/TargetAttribute.php';
require_once 'vendor/lib16/xml/src/shared/TitleAttribute.php';
require_once 'vendor/lib16/xml/src/shared/XmlAttributes.php';
require_once 'vendor/lib16/xml/src/shared/XmlStylesheet.php';
require_once 'vendor/lib16/xml/src/shared/XmlStylesheetInstruction.php';
require_once 'vendor/lib16/xml/src/shared/xlink/Actuate.php';
require_once 'vendor/lib16/xml/src/shared/xlink/Show.php';
require_once 'vendor/lib16/xml/src/shared/xlink/Type.php';
require_once 'vendor/lib16/xml/src/shared/xlink/XLink.php';
require_once 'vendor/lib16/xml/src/shared/xlink/XLinkConstants.php';

require_once 'src/Svg.php';
require_once 'src/enums/PreserveAspectRatio.php';
require_once 'src/enums/SpreadMethod.php';
require_once 'src/enums/Units.php';
