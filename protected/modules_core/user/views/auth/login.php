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
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/user/auth/style_custom.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user/auth/login.js', CClientScript::POS_END);
?>
<!-- Begin page content -->
<div class="container block-1 slide-sl">
    <div class="page_header ins_block">
        <ul class="inline_block">
            <li><a class="set-language<?php echo(Yii::app()->getLanguage() === 'ru' ? ' active' : ''); ?>" data-url="<?php echo(Yii::app()->createUrl('//user/lang')); ?>" data-lang="ru"><span id="ru"></span></a></li>
            <li><a class="set-language<?php echo(Yii::app()->getLanguage() === 'en' ? ' active' : ''); ?>" data-url="<?php echo(Yii::app()->createUrl('//user/lang')); ?>" data-lang="en"><span id="en"></span></a></li>
        </ul>
    </div>
    <div class="ins_block">
        <div class="logo"><img src="/img/logo.png" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" title="<?php echo CHtml::encode(Yii::app()->name); ?>"></div>
        <h1><?php echo(Yii::t('UserModule.views_auth_login', 'All monetization in one window')); ?></h1>
        <p class="fs"><a class="button cental_bl disable-element" href=""><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => 'Facebook'])); ?></a></p>
        <p class="gl"><a class="button cental_bl disable-element" href=""><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => 'Google plus'])); ?></a></p>
        <p class="login"><a class="button cental_bl login-link" data-toggle="modal" data-target="#loginModal"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Login using {login}', ['{login}' => Yii::t('UserModule.views_auth_login', 'login and password')])); ?></a></p>
        <p class="reg"><a class="button cental_bl scroller" data-id="#sl_3"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Sign up')); ?></a></p>
        <h2 class="format-1"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Statistics from all monetization tools are now collected on a single page')); ?></h2>
        <p class="b-light format-2">
            <?php echo(Yii::t('UserModule.views_auth_login', 'Thanks to <b> AnetBOX </ b> You can real-time monitor the effectiveness of the use of various tools and make the right decisions to increase revenue from their Internet projects. If you have more resources and use razlichnvye promotional tools, such as teaser networks, affiliate programs, contextual and banner ads as well as sell links and articles, the <b> AnetBOX </ b> is what you need!')); ?>
        </p>

        <p class="prezent"><a class="button cental_bl scroller" data-id="#sl_1"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Presentation of service')); ?></a></p>
    </div>
</div>

<div id="sl_1" class="container block-2">
    <h2 class="format-3"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'How does this work?')); ?></h2>
</div>

<div class="container block-3">

    <div class="ins_block" style="position: relative">
        <div id="onover" class="asn-gallery"></div>
        <div class="asn-gallery">
            <div data-item="0" class="bl4 bl-1"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Collect all<br>your resources')); ?></span></div>
            <div data-item="0" class="bl4 bl-2">
                <span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Register their site')); ?></span>
                <span class="desc"><?php echo(Yii::t('UserModule.views_auth_login', 'Add sites, lead accounting, evaluate, control proceeds')); ?></span>
            </div>
            <div data-item="0" class="bl4 bl-3"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Plug your network')); ?></span></div>
            <div data-item="0" class="bl4 bl-4"><span class="title-1"><?php echo(Yii::t('UserModule.views_auth_login', 'Get a complete picture<br>of their business')); ?></span></div>
            <div data-item="0" class="bl4 bl-5"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Maximize profits')); ?></span></div>
            <div data-item="0" class="bl4 bl-6"><span class="title-1"><?php echo(Yii::t('UserModule.views_auth_login', 'Choose effective<br>tools')); ?></span></div>
            <div data-item="0" class="bl4 bl-7"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Know who is selling, who is buying')); ?></span></div>
            <div data-item="0" class="bl4 bl-8"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Learn the news first')); ?></span></div>
            <div data-item="0" class="bl4 bl-9"><span class="title"><?php echo(Yii::t('UserModule.views_auth_login', 'Participate in the market')); ?></span></div>
        </div>
        <p class="partner"><a class="button cental_bl scroller" data-id="#sl_2"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Our partners')); ?></a></p>
    </div>
</div>

<div id="sl_2" class="container block-2">
    <h2 class="format-3"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Partners')); ?></h2>
</div>

<div class="container block-4">
    <div class="ins_block">
    <h3><?php echo(Yii::t('UserModule.views_auth_login', 'Advertising networks')); ?></h3>
    <ul class="inline_block reklama">
        <li><img src="/img/fon-3-1.jpg" alt=""></li>
        <li><img src="/img/fon-3-2.jpg" alt=""></li>
        <li><img src="/img/fon-3-3.jpg" alt=""></li>
        <li><img src="/img/fon-3-4.jpg" alt=""></li>
        <li><img src="/img/fon-3-1.jpg" alt=""></li>
        <li><img src="/img/fon-3-2.jpg" alt=""></li>
    </ul>
    <ul class="inline_block reklama">
        <li><img src="/img/fon-3-4.jpg" alt=""></li>
        <li><img src="/img/fon-3-3.jpg" alt=""></li>
        <li><img src="/img/fon-3-5.jpg" alt=""></li>
        <li><img src="/img/fon-3-6.jpg" alt=""></li>
        <li><img src="/img/fon-3-7.jpg" alt=""></li>
        <li><img src="/img/fon-3-8.jpg" alt=""></li>
    </ul>
    <h3><?php echo(Yii::t('UserModule.views_auth_login', 'Work with us')); ?></h3>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/img/foto-1.jpg" alt="AdmitAd">
                    <div class="container">
                        <div class="carousel-caption">
                            <?php echo(Yii::t('UserModule.views_auth_login', 'This partner network, providing technical and organizational capacity to conduct promotional campaigns involving a large number of web masters as partners.')); ?>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="/img/foto-2.jpg" alt="Market Gid">
                    <div class="container">
                        <div class="carousel-caption">
                          <?php echo(Yii::t('UserModule.views_auth_login', 'Teaser advertising network, which is part of the International Information and advertising network MIRS')); ?>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="/img/foto-1.jpg" alt="Republer">
                    <div class="container">
                        <div class="carousel-caption">
                            <?php echo(Yii::t('UserModule.views_auth_login', 'Technological platform for site owners, based on knowledge')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div><!-- /.carousel -->
        
        <p class="go_reg"><a class="button cental_bl scroller" data-id="#sl_3"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Go to registration')); ?></a></p>
    </div>
</div>

<div id="sl_3" class="container block-2">
    <h2 class="format-3"><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Register')); ?></h2>
</div>

<div class="container block-5">
    <div class="ins_block" style="position: relative;">
        <h2 class="format-9 ta_center"><?php echo(Yii::t('UserModule.views_auth_login', 'Register and gain access to any<br/> tools in one box')); ?></h2>
        <div class="bl_reg">
            <?php $form = $this->beginWidget('CActiveForm', ['id' => 'account-register-form', 'enableAjaxValidation' => false]); ?>
                <fieldset>
                    <p class="fs mb_15"><a class="button disable-element" href=""><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Register using {login}', ['{login}' => 'Facebook'])); ?></a></p>
                    <p class="gl mb_15"><a class="button disable-element" href=""><span></span><?php echo(Yii::t('UserModule.views_auth_login', 'Register using {login}', ['{login}' => 'Google plus'])); ?></a></p>

                    <?php if ($canRegister){ ?>
                        <p class="name_p mb_8 inline_block"><span></span>
                            <input type="text" class="w424 form-item" name="usercname" id="fullname" placeholder="<?php echo(Yii::t('UserModule.views_auth_login', 'Enter your nickname')); ?>" data-error="<?php echo('&larr; ' . Yii::t('UserModule.views_auth_login', 'at least 4 characters!')); ?>" data-info="<?php echo(Yii::t('UserModule.views_auth_login', 'the user name that will address your page anetbox.ru/yourname')); ?>" >
                        </p>
                        <p class="label_input fullname">
                            <?php echo(Yii::t('UserModule.views_auth_login', 'the user name that will address your page anetbox.ru/yourname')); ?>
                        </p>

                        <p class="email_p mb_8  inline_block"><span></span>
                            <?php echo $form->textField($registerModel, 'email', array('class' => 'w424 form-item', 'id' => 'email', 'placeholder' => Yii::t('UserModule.views_auth_login', 'Enter your email'), 'data-error' => '&larr; ' . Yii::t('UserModule.views_auth_login', 'Please enter a valid email'))); ?>
                        </p>
                        <p class="label_input email_lab<?php echo($form->error($registerModel, 'email') ? ' wrong' : ''); ?>">
                            <?php echo($form->error($registerModel, 'email') ? '&larr; ' . Yii::t('UserModule.views_auth_login', 'Please enter a valid email') : ''); ?>
                        </p>

                        <p class="pas_p mb_8 inline_block"><span></span>
                            <input class="w424 form-item" type="password" name="userpassword" id="password" placeholder="<?php echo(Yii::t('UserModule.views_auth_login', 'Enter your password')); ?>" data-error="<?php echo('&larr; ' . Yii::t('UserModule.views_auth_login', 'a password is very simple, at least 6 characters!')); ?>" >
                        </p>
                        <p class="label_input line_text_32 pass_lab<?php echo($form->error($registerModel, 'password') ? ' wrong' : ''); ?>">
                            <?php echo($form->error($registerModel, 'password') ? '&larr; ' . Yii::t('UserModule.views_auth_login', 'a password is very simple, at least 6 characters!') : ''); ?> 
                        </p>
                        
                        <p class="saveme_p mb_8">
                            <a class="password_toggle" data-show="<?php echo(Yii::t('UserModule.views_auth_login', 'Show password')); ?>" data-hide="<?php echo(Yii::t('UserModule.views_auth_login', 'Hide password')); ?>" ><?php echo(Yii::t('UserModule.views_auth_login', 'Show password')); ?></a>
                        </p>

                        <p></p>
                        <p class="site_p mb_8 inline_block site-items">
                            <span></span><input type="text" name="site[]" value="" class="w424 form-item" maxlength="90" placeholder="http://yoursite.com">
                        </p>
                        <p class="label_input"><?php echo(Yii::t('UserModule.views_auth_login', 'You can add more sites, graduating <br>registration in a private office')); ?></p>
                        <p class="add_p mb_8"><span></span><a class="add-site"><?php echo(Yii::t('UserModule.views_auth_login', 'Add site')); ?></a></p>
                        <?php /* ?>
                        <p class="saveme_p mb_8"><input type="checkbox" name="saveme">Запомнить меня</p>
                        <?php */ ?>
                    <?php } ?>
                </fieldset>
                <p class="but_reg">
                    <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Register'), array('class' => 'button', 'id'=> 'send')); ?>
                </p>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container footer">
        <div class="ins_block" >
            <div class="menu_footer">
                <p><?php echo(Yii::t('UserModule.views_auth_login', 'All products AdBase')); ?>:</p>
                <ul>
                    <li><a href="http://Reclamonetizator.ru">Reclamonetizator.ru</a></li>
                    <li><a href="http://Fincake.ru">Fincake.ru</a></li>
                    <li><a href="http://wow-impulse.ru">wow-impulse.ru</a></li>
                    <li><a href="http://vazhno.ru">vazhno.ru</a></li>
                </ul>
            </div>

            <div class="menu_footer">
                <p><?php echo(Yii::t('UserModule.views_auth_login', 'We are in social networks')); ?>:</p>
                <div class="social-likes" data-counters="no">
                    <div class="facebook" title="<?php echo(Yii::t('UserModule.views_auth_login', 'Share on {network}', ['{network}' => 'Facebook'])); ?>"></div>
                    <div class="twitter" title="<?php echo(Yii::t('UserModule.views_auth_login', 'Share on {network}', ['{network}' => 'Twitter'])); ?>"></div>
                    <div class="plusone" title="<?php echo(Yii::t('UserModule.views_auth_login', 'Share on {network}', ['{network}' => 'Google plus'])); ?>"></div>
                </div>
            </div>
            
            <div class="menu_footer format-10">
                <p class="copyrite"> &#169;AnetBox <?php echo(date('Y')); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo(Yii::t('ProfileModule.base', 'Close')); ?>"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="loginModalLabel"><?php echo(Yii::t('UserModule.views_auth_login', 'Sign in to site')); ?></h4>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'account-login-form',
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="login_username" class="control-label"><?php echo(Yii::t('UserModule.views_auth_login', 'Login/E-mail')); ?>:</label>
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'id' => 'login_username', 'placeholder' => Yii::t('UserModule.views_auth_login', 'username or email'))); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>
                <div class="form-group">
                    <label for="login_username" class="control-label"><?php echo(Yii::t('UserModule.views_auth_login', 'Password')); ?>:</label>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'id' => 'login_password', 'placeholder' => Yii::t('UserModule.views_auth_login', 'password'))); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?php echo($form->checkBox($model, 'rememberMe') . Yii::t('UserModule.views_auth_login', 'Remember me next time')); ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <a href="<?php echo $this->createUrl('//user/auth/recoverPassword'); ?>"><?php echo(Yii::t('UserModule.views_auth_login', 'Forgot your password?')); ?></a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo(Yii::t('ProfileModule.base', 'Close')); ?></button>
                <?php echo CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Sign in'), array('class' => 'btn btn-primary text-center')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>