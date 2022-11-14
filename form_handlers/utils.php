<?php

function sanitizeInput($value)
{
    /* Sanitizing the input. */
    return htmlspecialchars(stripslashes(trim($value)));
}