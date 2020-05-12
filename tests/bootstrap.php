<?php
require_once 'vendor/autoload.php';

// @todo for Travis CI
require_once 'vendor/lib16/utils/src/enums/css/Unit.php';
require_once 'vendor/lib16/utils/src/enums/css/LengthUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/Media.php';
require_once 'vendor/lib16/utils/src/enums/mime/MimeType.php';
require_once 'vendor/lib16/utils/src/enums/mime/StyleType.php';
require_once 'vendor/lib16/svg/src/Adhoc.php';
require_once 'vendor/lib16/svg/src/Attributes.php';
require_once 'vendor/lib16/svg/src/ProcessingInstruction.php';
require_once 'vendor/lib16/svg/src/Xml.php';
require_once 'vendor/lib16/svg/src/XmlWrapper.php';
require_once 'vendor/lib16/svg/src/shared/ClassAttribute.php';
require_once 'vendor/lib16/svg/src/shared/MediaAttribute.php';
require_once 'vendor/lib16/svg/src/shared/Space.php';
require_once 'vendor/lib16/svg/src/shared/Target.php';
require_once 'vendor/lib16/svg/src/shared/TargetAttribute.php';
require_once 'vendor/lib16/svg/src/shared/TitleAttribute.php';
require_once 'vendor/lib16/svg/src/shared/XmlAttributes.php';
require_once 'vendor/lib16/svg/src/shared/XmlStylesheet.php';
require_once 'vendor/lib16/svg/src/shared/XmlStylesheetInstruction.php';
require_once 'vendor/lib16/svg/src/shared/xlink/Actuate.php';
require_once 'vendor/lib16/svg/src/shared/xlink/Show.php';
require_once 'vendor/lib16/svg/src/shared/xlink/Type.php';
require_once 'vendor/lib16/svg/src/shared/xlink/XLink.php';
require_once 'vendor/lib16/svg/src/shared/xlink/XLinkConstants.php';

require_once 'src/Svg.php';
require_once 'src/enums/PreserveAspectRatio.php';
require_once 'src/enums/SpreadMethod.php';
require_once 'src/enums/Units.php';
