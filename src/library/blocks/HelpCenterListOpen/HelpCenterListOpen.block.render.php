<?php

function acf_block_render_callback_HelpCenterListOpen($block)
{
    $slug = str_replace('acf/', '', $block['name']);

    $context = Timber::get_context();
    $context['block'] = $block;
    $context['fields'] = get_fields();

    Timber::render('./HelpCenterListOpen.block.view.twig', $context);
}