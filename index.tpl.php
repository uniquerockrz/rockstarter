<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hello World - Saurav Modak</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/mystyles.css" rel="stylesheet">
</head>
<body>
<script src="js/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php $this->RenderBegin(); ?>
<!-- Email Modal Start -->
<div id="emailForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="emailform" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="emailform">Enter Email Address</h3>
    </div>
    <div class="modal-body">
        <p class="text-error"><?php $this->lblMsg->Render(); ?></p>
        <p class="text-success"><?php $this->lblMsg1->Render(); ?></p>
        <?php $this->txtBox1->RenderWithError(); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <?php $this->btnSubmit->Render(); ?>
    </div>
</div>
<!-- Email Modal End -->
<div class="row">
    <div class="span10 offset2">
        <div class="paper-roll">
            <div class="container rounded-white">
                <div class="row">
                    <div class="offset4">
                        <h3>Hello World - Man At Work</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="offset3">
                        <img src="img/under-construction.gif" class="img-rounded">
                    </div>
                </div>
                <div class="spacing-10"></div>
                <div class="row">
                    <div class="span1">
                        <strong>10%</strong>
                    </div>
                    <div class="span11">
                        <div class="progress progress-striped active">
                            <div class="bar" style="width: 10%;"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span12">
                        <em>In case you wish to know when the website is ready, I can send you a one time email when its done. I won't store any of the email addresses for spamming and they will be discarded when messages have been sent. You may also check out the work blog from links below to know the detailed progress of this site.</em>
                    </div>
                </div>
                <div class="row">
                    <div class="span5 offset4">
                        <a href="#emailForm" class="btn btn-large btn-success" data-toggle="modal">Register for E-Mail Notification</a>
                    </div>
                </div>
                <div class="spacing-10"></div>
                <div class="row">
                    <div class="span9 offset2">
                        <a href="http://www.facebook.com/sauravmodak" class="btn btn-primary">Facebook Profile</a>&nbsp;&nbsp;&nbsp;<a href="http://www.facebook.com/linuxb.in" class="btn btn-primary">Facebook Page</a>&nbsp;&nbsp;&nbsp;<a href="https://twitter.com/SauravAtFreedom" class="btn btn-primary">Twitter</a>&nbsp;&nbsp;&nbsp;<a href="mailto:support@linuxb.in" class="btn btn-primary">Email</a>&nbsp;&nbsp;&nbsp;<a href="http://www.linuxb.in" class="btn btn-primary">Linux Blog</a>&nbsp;&nbsp;&nbsp;<a href="/blog" class="btn btn-primary">Work Blog</a>
                    </div>
                </div>
            </div>
            <div class="container rounded-dark">
                <div class="row">
                    <div class="span11 offset1">
                        Created by Saurav Modak "uniquerockrz", Source code available under Public Domain, do whatever the hell you like.
                    </div>
                </div>
            </div>
        </div>
    </div>>
</div>
<?php $this->RenderEnd(); ?>
</body>
</html>