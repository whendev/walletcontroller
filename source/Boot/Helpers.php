<?php

// VALIDATE

/**
 * @param string $email
 * @return mixed
 */
function is_email(string $email){
    return filter_var($email , FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    if (password_get_info($password)['algo'] || mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password <= CONF_PASSWD_MAX_LEN)){
        return true;
    }
    return false;
}



// REQUEST

// STRING

// URL

// ASSETS

// DATE

// CORE

// MODEL






