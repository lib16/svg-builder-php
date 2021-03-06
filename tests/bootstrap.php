<?php
require_once 'vendor/autoload.php';

// @todo for Travis CI
require_once 'vendor/lib16/utils/src/NumberFormatter.php';
require_once 'vendor/lib16/utils/src/enums/css/Unit.php';
require_once 'vendor/lib16/utils/src/enums/css/AngleUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/FrequencyUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/LengthUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/TimeUnit.php';
require_once 'vendor/lib16/utils/src/enums/css/Media.php';
require_once 'vendor/lib16/utils/src/enums/mime/MimeType.php';
require_once 'vendor/lib16/utils/src/enums/mime/AudioType.php';
require_once 'vendor/lib16/utils/src/enums/mime/IconType.php';
require_once 'vendor/lib16/utils/src/enums/mime/ImageType.php';
require_once 'vendor/lib16/utils/src/enums/mime/StyleType.php';
require_once 'vendor/lib16/utils/src/enums/mime/VideoType.php';
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
require_once 'vendor/lib16/graphics/src/colors/Colors.php';
require_once 'vendor/lib16/graphics/src/colors/Colors8Bit.php';
require_once 'vendor/lib16/graphics/src/geometry/Angle.php';
require_once 'vendor/lib16/graphics/src/geometry/Point.php';
require_once 'vendor/lib16/graphics/src/geometry/PointSet.php';
require_once 'vendor/lib16/graphics/src/geometry/Command.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/Arc.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/ClosePath.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/CubicCurveTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/HorizontalLineTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/LineTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/MoveTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/QuadraticCurveTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/SmoothCubicCurveTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/SmoothQuadraticCurveTo.php';
require_once 'vendor/lib16/graphics/src/geometry/pathcommands/VerticalLineTo.php';
require_once 'vendor/lib16/graphics/src/geometry/Path.php';

require_once 'src/Svg.php';
require_once 'src/enums/PreserveAspectRatio.php';
require_once 'src/enums/SpreadMethod.php';
require_once 'src/enums/Units.php';
