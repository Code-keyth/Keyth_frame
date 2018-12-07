<?php

/* Index/index.html */
class __TwigTemplate_6e92892f52500fdcf729f1a5814896381514f7099896902187ca6d5688b68dfe extends Twig_Template
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
        // line 10
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo ", your mobile is ";
        echo twig_escape_filter($this->env, (isset($context["mobile"]) ? $context["mobile"] : null), "html", null, true);
        echo "


<ul id=\"navigation\">
    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["navigation"]) ? $context["navigation"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 15
            echo "    <li>";
            echo twig_escape_filter($this->env, $context["item"], "html", null, true);
            echo "</li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "</ul>

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
        return array (  52 => 17,  43 => 15,  39 => 14,  30 => 10,  19 => 1,);
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
    {% for item in navigation %}
    <li>{{ item }}</li>
    {% endfor %}
</ul>

<footer>footer1</footer>
</body>
</html>", "Index/index.html", "/home/wwwroot/Site/keyth001.com/Views/Index/index.html");
    }
}
