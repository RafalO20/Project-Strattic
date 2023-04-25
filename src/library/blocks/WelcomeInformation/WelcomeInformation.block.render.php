<?php

function acf_block_render_callback_WelcomeInformation($block)
{
    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::get_context();
    $context['block'] = $block;
    $context['fields'] = get_fields();

    Timber::render('./WelcomeInformation.block.view.twig', $context);
}