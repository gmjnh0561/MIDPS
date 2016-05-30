<?php

function miranda() {
    return new Miranda(
        // Path to template files.
        Config::get('project.template_files')
    );
};