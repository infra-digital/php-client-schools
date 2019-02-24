<?php

interface AdapterInterface {
    public function getResponseCode();

    public function getResponse();

    public function getRawResponse();
}