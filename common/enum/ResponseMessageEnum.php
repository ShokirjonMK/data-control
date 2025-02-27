<?php

namespace common\enum;

enum ResponseMessageEnum : string
{
   case Success = 'success';
   case Error = 'error';
   case Warning = 'warning';
   case Info = 'info';
   case ProductStatus = 'Products successfully updated to delivered status';
   case ProductStatusErr = 'Failed to update products to delivered status. Please check the product IDs and try again.';
}
