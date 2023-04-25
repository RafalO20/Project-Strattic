<?php

function acf_block_render_callback_FeaturesBoxes($block)
{
    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::get_context();
    $context['block'] = $block;
    $context['fields'] = get_fields();

    Timber::render('./FeaturesBoxes.block.view.twig', $context);
}