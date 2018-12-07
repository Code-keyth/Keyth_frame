<?php

/* Index/index.html */
class __TwigTemplate_0acfc178e1a380214bac54dbe3fcd214423744ed5ab5e1eaed8740bb7a3df80e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
<header>header</header>
";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo ", your mobile is ";
        echo twig_escape_filter($this->env, (isset($context["mobile"]) ? $context["mobile"] : null), "html", null, true);
        echo "
<ul id=\"navigation\">
1
</ul>

<form method=\"post\" enctype=\"multipart/form-data\">

    姓名：<input name=\"name\" type=\"text\">
    电话：<input name=\"mobile\" type=\"text\">
    验证码：<input name=\"captcha\" type=\"text\">
    附件：<input name=\"img\" type=\"file\">
    ";
        // line 21
        echo "    ";
        echo (isset($context["captcha"]) ? $context["captcha"] : null);
        echo "
    ";
        // line 23
        echo "<button type=\"submit\">提交</button>
</form>
<footer>footer1</footer>



</body>
</html>";
    }

    public function getTemplateName()
    {
        return "Index/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 23,  45 => 21,  29 => 9,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
<header>header</header>
{{ name }}, your mobile is {{ mobile }}
<ul id=\"navigation\">
1
</ul>

<form method=\"post\" enctype=\"multipart/form-data\">

    姓名：<input name=\"name\" type=\"text\">
    电话：<input name=\"mobile\" type=\"text\">
    验证码：<input name=\"captcha\" type=\"text\">
    附件：<input name=\"img\" type=\"file\">
    {% autoescape false %}
    {{ captcha }}
    {% endautoescape %}
<button type=\"submit\">提交</button>
</form>
<footer>footer1</footer>



</body>
</html>", "Index/index.html", "/home/wwwroot/Site/keyth001.com/App/Views/Index/index.html");
    }
}
