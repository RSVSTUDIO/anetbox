<?php
/**
 * Login and registration page by AuthController
 *
 * @property CFormModel $model is the login form.
 * @property CFormModel $registerModel is the registration form.
 * @property Boolean $canRegister indicates that anonymous registrations are enabled.
 *
 * @package humhub.modules_core.user.views
 * @since 0.5
 */
$this->pageTitle = Yii::t('UserModule.views_auth_login', '<strong>Please</strong> sign in');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/auth/login.js', CClientScript::POS_END);
?>
<!-- PAGE 1 *********************************************************************************************************** -->
<div id="page_1" class="row">
    <div class="row headline">

        <div class="container text-right">
            <a class="set-language<?php echo(Yii::app()->getLanguage() === 'en' ? ' active' : ''); ?>" data-url="<?php echo(Yii::app()->createUrl('//user/lang')); ?>" data-lang="en"><img class="lang_banner" src="img/anetbox/en.png"></a>
            <a class="set-language<?php echo(Yii::app()->getLanguage() === 'ru' ? ' active' : ''); ?>" data-url="<?php echo(Yii::app()->createUrl('//user/lang')); ?>" data-lang="ru"><img class="lang_banner" src="img/anetbox/ru.png"></a>
        </div>
    </div>
    <div class="container screen text-center">

        <div class="row">
            <img id="anetlogo" src="img/anetbox/AnetLogo.png" />
            <p id="app-title" class="animated fadeIn" style="text-transform: lowercase;font-size: 2em;"><?php echo CHtml::encode(Yii::app()->name); ?></p>
            <h1><?php echo(Yii::t('UserModule.views_auth_login', 'All monetization in one window')); ?></h1>
        </div>
        <div class="row text-left">
            <div class="col-lg-4 col-lg-offset-2 enter_fb ">
                <br/>
                <button type="button" class="btn btn_social social_fb text-left" aria-label="Facebook Login">
                    <i class="fa fa-facebook"></i>
                    <span class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => 'Facebook'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </button>
            </div>
        </div>
        <div class="row text-left">
            <br/>
            <div class="col-lg-4 col-lg-offset-2 enter_fb ">
                <button type="button" class="btn btn_social social_gp text-left" aria-label="Google plus login">
                    <i class="fa fa-google-plus"></i>
                    <span class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => 'Google Plus'])); ?></span>
                </button>
            </div>
        </div>
        <div class="row text-left">
            <br/>
            <div class="col-lg-4 col-lg-offset-2 ">
                <button type="button" class="btn btn_reg getlogin" data-id="#login-form" aria-label="Login">
                    <i class="fa fa-key" ></i>
                    <a class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => Yii::t('UserModule.views_auth_login', 'login and password')])); ?></a>
                </button>
            </div>
        </div>
        <!-- Login Form -->
        <div class="panel panel-default hide" id="login-form" tabindex="-1" style="max-width: 400px; margin: 0 auto 20px; text-align: left;">

            <div class="panel-heading text-center">
                <button type="button" class="close" data-dismiss="modal" area-hidden="true" onclick="$('#login-form').addClass('hide')">X</button>
                <h3><?php echo(Yii::t('UserModule.views_auth_login', 'Sign in to site')); ?></h3>
            </div>

            <div class="panel-body">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'account-login-form',
                    'enableAjaxValidation' => false,
                ));
                ?>

                <div class="form-group form-inline">
                    <label for="login_username"><?php echo(Yii::t('UserModule.views_auth_login', 'Login/E-mail')); ?>:</label>
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'id' => 'login_username', 'placeholder' => Yii::t('UserModule.views_auth_login', 'username or email'))); ?>

                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="form-group form-inline">
                    <label for="login_username"><?php echo(Yii::t('UserModule.views_auth_login', 'Password')); ?>:</label>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'id' => 'login_password', 'placeholder' => Yii::t('UserModule.views_auth_login', 'password'))); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-1">
                        <div class="checkbox">
                            <label>
                                <?php echo($form->checkBox($model, 'rememberMe') . Yii::t('UserModule.views_auth_login', 'Remember me next time')); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-1">
                        <a href="<?php echo $this->createUrl('//user/auth/recoverPassword'); ?>"><?php echo(Yii::t('UserModule.views_auth_login', 'Forgot your password?')); ?></a>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-8 col-lg-offset-2">
                        <br/>
                        <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Sign in'), array('class' => 'btn btn-warning text-center')); ?>
                    </div>

                </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>
        <div class="row text-left">
            <br/>
            <div class="col-lg-4 col-lg-offset-2 ">
                <button type="button" class="btn btn_reg scroller" data-id="#page_4" aria-label="Facebook login">
                    <i class="fa fa-user"></i>
                    <a class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Sign up')); ?></a>
                </button>
            </div>
        </div>



        <div class="container">
            <div class="col-9 col-lg-offset-2 text-left">
                <h2 style="text-indent: -1em;"><span class="bigchar">»</span> <?php echo(Yii::t('UserModule.views_auth_login', 'Statistics from all monetization tools are now collected on a single page')); ?></h2>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 text-left">
                <p>
                    <?php echo(Yii::t('UserModule.views_auth_login', 'Thanks to <b> AnetBOX </ b> You can real-time monitor the effectiveness of the use of various tools and make the right decisions to increase revenue from their Internet projects. If you have more resources and use razlichnvye promotional tools, such as teaser networks, affiliate programs, contextual and banner ads as well as sell links and articles, the <b> AnetBOX </ b> is what you need!')); ?>
                </p>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-lg-offset-4">
                <button type="button" class="btn btn_next scroller" data-id="#page_2" aria-label="Facebook login">
                    <i class="fa fa-film"></i>
                    <a class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Presentation of service')); ?></a>
                </button>
            </div>
        </div>
    </div>



</div>


<!-- PAGE 2 *********************************************************************************************************** -->

<div id="page_2" class="row" style="min-height: 755px;">
    <div class="row sectionline">
        <div class="container text-left sectionline">
            <h4><span class="bigchar">»</span>&nbsp;<?php echo(Yii::t('UserModule.views_auth_login', 'How does this work')); ?></h4>

        </div>
    </div>
    <div class="container screen" style="text-align: center;">
        <div  class="row">
            <img src="img/anetbox/screen_2.png" width="1200" height="695" />
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-lg-offset-4">
                <button type="button" class="btn btn_next scroller" data-id="#page_3" aria-label="Facebook login">
                    <i class="fa fa-group"></i>
                    <a class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Our partners')); ?></a>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PAGE 3 *********************************************************************************************************** -->
<div id="page_3" class="row">
    <div class="row sectionline">
        <div class="container text-left sectionline">
            <h4><span class="bigchar">»</span>&nbsp;<?php echo(Yii::t('UserModule.views_auth_login', 'Partners')); ?></h4>

        </div>
    </div>
    <div class="container screen" style="text-align: center;">
        <div class="row text-left">
            <h2 class="orange"><?php echo(Yii::t('UserModule.views_auth_login', 'Advertising networks')); ?></h2>
        </div>
        <div  class="row">
            <div class="col-lg-2"><img src="img/anetbox/Google.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/Republer.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/AdmitAd.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/MarketGid.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/Google.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/Republer.png" /></div>
        </div>
        <div  class="row">
            <div class="col-lg-2"><img src="img/anetbox/Sape.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/Lamoda.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/Google.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/MarketGid.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/FreLance.png" /></div>
            <div class="col-lg-2"><img src="img/anetbox/AdmitAd.png" /></div>
        </div>
    </div>    
        
    <div class="container">
        <div class="row text-left">
            <h2 class="orange"><?php echo(Yii::t('UserModule.views_auth_login', 'Work with us')); ?>:</h2>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <!-- Carousel
                    ================================================== -->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <!-- <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                        <li data-target="#myCarousel" data-slide-to="5"></li>
                        <li data-target="#myCarousel" data-slide-to="6"></li>
        
                    </ol> -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-1">
                                        <div class="slide-image">
                                            <div class="thumbnail">
                                                <img class="first-slide" src="img/anetbox/Google.png" alt="Google Plus">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="slide-content text-left">
                                            <h3>Google AdSense</h3>
                                            <p><?php echo(Yii::t('UserModule.views_auth_login', 'AdSense is a free, easy way to earn money by displaying targeted ads next to online content. With AdSense, you can display relevant and engaging ads to your site visitors and even customize the look and feel for your according to your website.')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-1">
                                        <div class="slide-image">
                                            <div class="thumbnail">
                                                <img class="first-slide" src="img/anetbox/Sape.png" alt="Google Plus">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="slide-content text-left">
                                            <h3>Sape</h3>
                                            <p><?php echo(Yii::t('UserModule.views_auth_login', 'This system of buying - selling links from the main and inner pages of sites, which includes a number of unique services')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-1">
                                        <div class="slide-image">
                                            <div class="thumbnail">
                                                <img class="first-slide" src="img/anetbox/AdmitAd.png" alt="Google Plus">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="slide-content text-left">
                                            <h3>AdmitAd</h3>
                                            <p><?php echo(Yii::t('UserModule.views_auth_login', 'This partner network, providing technical and organizational capacity to conduct promotional campaigns involving a large number of web masters as partners.')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-1">
                                        <div class="slide-image">
                                            <div class="thumbnail">
                                                <img class="first-slide" src="img/anetbox/MarketGid.png" alt="Google Plus">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="slide-content text-left">
                                            <h3><?php echo(Yii::t('UserModule.views_auth_login', 'MarketGid')); ?></h3>
                                            <p><?php echo(Yii::t('UserModule.views_auth_login', 'Teaser advertising network, which is part of the International Information and advertising network MIRS')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-1">
                                        <div class="slide-image">
                                            <div class="thumbnail">
                                                <img class="first-slide" src="img/anetbox/Republer.png" alt="Google Plus">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="slide-content text-left">
                                            <h3>Republer</h3>
                                            <p><?php echo(Yii::t('UserModule.views_auth_login', 'Technological platform for site owners, based on knowledge')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                </div><!-- /.carousel -->
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-lg-offset-4">
                <button type="button" class="btn btn_next scroller" data-id="#page_4" aria-label="Facebook login">
                    <i class="fa fa-edit"></i>
                    <a class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Go to registration')); ?></a>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PAGE 4 *********************************************************************************************************** -->
<div id="page_4" class="row">
    <div class="row sectionline">
        <div class="container text-left sectionline">
            <h4><span class="bigchar">»</span>&nbsp;<?php echo(Yii::t('UserModule.views_auth_login', 'Register')); ?></h4>

        </div>
    </div>
    <div class="container screen last_page text-center" style="text-align: center;">
        <h2><?php echo(Yii::t('UserModule.views_auth_login', 'Register and gain access to any<br/> tools in one box')); ?></h2>
        <div  class="row">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'account-register-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="col-lg-12">
                <div class="row text-left">
                    <div class="col-lg-4 col-lg-offset-1">
                        <br/>
                        <button type="button" class="btn btn_social social_fb text-left" aria-label="Facebook login">
                            <i class="fa fa-facebook" style="font-size: 1.1em;"></i>
                            <span class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Register using {login}', ['{login}' => 'Facebook'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </button>
                    </div>
                </div>
                <div class="row text-left">
                    <br/>
                    <div class="col-lg-4 col-lg-offset-1">
                        <button type="button" class="btn btn_social social_gp text-left" aria-label="Google Plus login">
                            <i class="fa fa-google-plus"></i>
                            <span class="btn_label"><?php echo(Yii::t('UserModule.views_auth_login', 'Register using {login}', ['{login}' => 'Google Plus'])); ?></span>
                        </button>
                    </div>
                </div>
                <!-- ********************* -->

                <?php if ($canRegister) : ?>

                    <!-- animated bounceInLeft -->
                    <div id="register-form" class="row ">
                        <br/>

                        <div class="row">
                            <div class="col-lg-1 text-right form_checker_first">
                                <div class="input-group " >
                                    <i class="fa fa-check-circle-o bigicon"></i>
                                </div>
                            </div>
                            <div class="col-lg-4 text-left">
                                <div class="input-group ">
                                    <div class="input-group-addon"><i class="fa fa-user "></i></div>
                                    <input id="register_cname" class="form-control" type="text" name="usercname" placeholder="<?php echo(Yii::t('UserModule.views_auth_login', 'Enter your nickname')); ?>">
                                </div>
                            </div>
                            <div class="col-lg-7 text-left">
                                <p style="margin-left: 20px; color:#999999;"> <br/><?php echo(Yii::t('UserModule.views_auth_login', 'the user name that will address your page anetbox.ru/yourname')); ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-1 text-right form_checker">
                                <div class="input-group " >
                                    <i class="fa fa-check-circle-o bigicon"></i>
                                </div>
                            </div>

                            <div class="col-lg-4  text-left">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-envelope "></i></div>
                                    <?php echo $form->textField($registerModel, 'email', array('class' => 'form-control input_reg', 'id' => 'register-email', 'placeholder' => Yii::t('UserModule.views_auth_login', 'email'))); ?>


                                </div>
                            </div>
                            <div class="col-lg-7 text-left">
                                <?php echo $form->error($registerModel, 'email'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-1 text-right">
                                <div class="input-group">
                                    <i class="fa fa-crosshairs bigicon"></i>
                                </div>
                            </div>

                            <div class="col-lg-4 text-left">
                                <div class="input-group ">
                                    <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                    <input id="userpass" class="form-control" type="password" name="userpassword" placeholder="<?php echo(Yii::t('UserModule.views_auth_login', 'Enter your password')); ?>">
                                </div>
                            </div>
                            <div class="col-lg-7 text-left">
                                <p style="margin-left: 20px; color:#999999;"> <br/> <?php echo(Yii::t('UserModule.views_auth_login', 'the password is too simple')); ?></p>
                                <?php /* echo $form->error($registerModel, 'password'); */ ?>
                            </div>
                        </div>

                        <div class="col-lg-4 col-lg-offset-1 text-left">
                            <div class="input-group nodecor ">
                                <div class="input-group-addon nodecor"><i class="fa fa-check bigicon"></i></div>
                                <a href="#" class="form-control nodecor password_toggle" data-show="<?php echo(Yii::t('UserModule.views_auth_login', 'Show password')); ?>" data-hide="<?php echo(Yii::t('UserModule.views_auth_login', 'Hide password')); ?>" ><?php echo(Yii::t('UserModule.views_auth_login', 'Show password')); ?></a>
                            </div>
                        </div>
                        <?php /* ?>
                            <div class="input-group nodecor ">
                                <div class="input-group-addon nodecor"><i class="fa fa-globe bigicon"></i></div>
                                <input id="usersite" class="form-control nodecor" type="text" name="usersite" placeholder="Укажите ваш сайт">
                            </div>

                            <div class="input-group nodecor ">
                                <div class="input-group-addon nodecor"><i class="fa fa-plus bigicon"></i></div>
                                <input id="usersite" class="form-control nodecor" type="text" name="usersite" placeholder="Добавитьсайт">
                            </div>
                            <div class="input-group nodecor ">
                                <div class="input-group-addon nodecor"><i class="fa fa-check bigicon"></i></div>
                                <a href="#" id="usersite" class="form-control nodecor" >Запомнить меня</a>
                            </div>
                        <?php */ ?>
                    </div>

                <?php endif; ?>

            </div>
            <br/>
            <div class="row text-left">

                <div class="col-lg-3 col-lg-offset-2 text-center">
                    <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Register'), array('class' => 'btn btn-warning text-center')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<br>

<!-- Footer *********************************************************************************************************** -->
<div id="page_footer" class="row sectionline">
    <div class="col-lg-2 col-lg-offset-2 text-left">
        <h4><?php echo(Yii::t('UserModule.views_auth_login', 'All products AdBase')); ?>:</h4>
        <ul>
            <li><a href="http://reclamonetizator.ru">Reclamonetizator.ru</a></li>
            <li><a href="http://fincake.ru">Fincake.ru</a></li>
            <li><a href="http://wow-impulse.ru">WOW-Impulse.ru</a></li>
            <li><a href="http://vazhno.ru"></a>Vazhno.ru</li>
        </ul>
    </div>
    <div class="col-lg-2">
        <h4><?php echo(Yii::t('UserModule.views_auth_login', 'We are in social networks')); ?></h4>
        <ul >
            <li style="display: inline-block; width:2em;"><a href="http://facebook.com"><img src="img/anetbox/FB.png" /></a></li>
            <li style="display: inline-block; width:2em;"><a href="http://google.com"><img src="img/anetbox/GP.png" /></a></li>
            <li style="display: inline-block; width:2em;"><a href="http://twitter.com"><img src="img/anetbox/TW.png" /></a></li>
        </ul>
    </div>
    <div class="col-lg-6 text-right">
        <h6>&copy;&nbsp;Copyright AnetBOX <?php echo(date('Y')); ?></h6>
    </div>
</div>