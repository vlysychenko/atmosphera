
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Atmosphera</title>
    <? Yii::app()->clientScript->registerCSSFile(Yii::app()->request->baseUrl.'/css/access.css');?>
</head>
<body>

    <table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td align="center">
            <span id="main">
                <span id="block" class="clearfix">

                        <?php echo $content; ?>

                </span>
            </span>
        </td>
    </tr>
    </table>

</body>
</html>