<?php

class QIWIMcryptEncrypter {
  function encrypt($message, $key) {
    return  mcrypt_encrypt(MCRYPT_3DES, $key, $message, MCRYPT_MODE_ECB, "\0\0\0\0\0\0\0\0");
  }
}