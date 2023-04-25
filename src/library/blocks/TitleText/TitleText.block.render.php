<?php

function acf_block_render_callback_TitleText($block)
{
    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::get_context();
    $context['block'] = $block;
    $context['fields'] = get_fields();

    Timber::render('./TitleText.block.view.twig', $context);
}