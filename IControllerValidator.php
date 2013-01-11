<html>
<head>
    <style type="text/css">
        body {
            background-color: #84817b;
            font-family: Arial;
        }
        .headers {
            font-size: 20;
            display: inline-block;
            padding-left: 20;
            padding-right: 20;
            margin-left:20;
            margin-right:20;
            background: #b6abb3;
            -moz-border-radius: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .problems
        {
            text-align: center;
            box-shadow: 2px 2px 7px black;
        }
        textarea {
            width: 100%;
        }
        .input
        {
            text-align: center;
            height: 70px;
            box-shadow: 2px 2px 7px black;
        }
    </style>
    <title>Validate your XML against our schema</title>
</head>
<body>
<h1 class="headers">Validate your XML against our schema</h1>

<form name='validation' action="IControllerValidator.php" method="POST">

    <b>XML:</b><br>

    <textarea name='xml' rows="40" ><?php
        if (isset($_POST["xml"]))
            echo $_POST["xml"];
        ?></textarea>

    <br><input type='submit' value='Validate XML'>

</form>
<?php
if (isset($_POST["xml"]))
{
    ?>
<h1 class="headers">validation results</h1>
    <?php

    function libxml_display_error($error)
    {
        $return = "<br/>\n";
        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "<b>Warning $error->code</b>: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "<b>Error $error->code</b>: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "<b>Fatal Error $error->code</b>: ";
                break;
        }
        $return .= trim($error->message);
        if ($error->file) {
            $return .=    " in <b>$error->file</b>";
        }
        $return .= " on line <b>$error->line</b>\n";

        return $return;
    }

    function libxml_display_errors() {
        $errors = libxml_get_errors();
        foreach ($errors as $error) {
            print libxml_display_error($error);
        }
        libxml_clear_errors();
    }

// Enable user error handling
    libxml_use_internal_errors(true);

    $xml = new DOMDocument();
    $xml->loadXML($_POST["xml"]);


    if (!$xml->schemaValidate('icontroller-import.xsd')) {
        print '<div class="problems"><b>DOMDocument::schemaValidate() Generated Errors!</b>';
        libxml_display_errors();
        print '</div>';
    }
    else {
        echo "validated";
    }

}
?>

</html>