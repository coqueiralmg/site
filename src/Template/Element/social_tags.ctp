<?php

if (isset($socialTags))
{
    echo $this->Html->meta('og:locale', $socialTags['og:locale']);
    echo $this->Html->meta('og:type', $socialTags['og:type']);
    echo $this->Html->meta('article:publisher', $socialTags['article:publisher']);
    echo $this->Html->meta('og:title', $socialTags['og:title']);
    echo $this->Html->meta('og:description', $socialTags['og:description']);
    echo $this->Html->meta('og:url', $socialTags['og:url']);
    echo $this->Html->meta('og:site_name', $socialTags['og:site_name']);
    echo $this->Html->meta('og:image', $socialTags['og:image']);
    echo $this->Html->meta('og:image:width', $socialTags['og:image:width']);
    echo $this->Html->meta('og:image:height', $socialTags['og:image:height']);
}
else
{
    echo $this->Html->meta('og:image', 'img/logotipo1.png'); 
    echo $this->Html->meta('og:image:width', '600');
    echo $this->Html->meta('og:image:height', '400');
}

?>