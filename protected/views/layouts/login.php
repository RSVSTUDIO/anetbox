<?php
//register default script and css
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/default.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/default.css');
?>
<!DOCTYPE html>
<html lang="<?php echo(Yii::app()->getLanguage()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=1200" />
    <meta name="MobileOptimized" content="1200" />
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/ico/favicon.ico">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/validform.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/css-dop/sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/css-dop/carousel.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/social-likes_flat.css" />
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/user/auth/style.css" rel="stylesheet">
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/assets/docs.min.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/jquery.scrollTo.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/style.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/validation.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/social-likes.min.js"></script>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="<?php echo Yii::app()->baseUrl; ?>/js/user/auth/assets/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<?php echo($content); ?>

</body>
</html>