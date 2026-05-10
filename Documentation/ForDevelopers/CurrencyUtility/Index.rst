.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.rst.txt


.. _currencyutility:

===============
CurrencyUtility
===============

The :php:`\DERHANSEN\SfEventMgt\Utility\CurrencyUtility` class provides a built-in, dependency-free
ISO 4217 currency dataset covering all standard currencies. Each currency entry contains the
alphabetic code, numeric code, name, and symbol.

This utility is particularly useful when integrating custom payment providers that require
ISO 4217 currency codes or symbols - for example, when building a custom payment method
extension for sf_event_mgt that communicates with an external payment gateway (e.g. Stripe,
PayPal, or Mollie). Since the event price currency is stored as an ISO 4217 code on the event
record, the utility allows you to resolve the full currency data at runtime without adding
external dependencies.

API
---

.. php:class:: \DERHANSEN\SfEventMgt\Utility\CurrencyUtility

   .. php:method:: getByIsoCode(string $isoCode)

      Returns the currency data array for the given ISO 4217 alphabetic code (case-insensitive),
      or :php:`null` if the code is not found.

      The returned array contains the following keys:

      * :php:`code` — ISO 4217 alphabetic code (e.g. :php:`'EUR'`)
      * :php:`numeric` — ISO 4217 numeric code (e.g. :php:`'978'`)
      * :php:`name` — Human-readable currency name (e.g. :php:`'Euro'`)
      * :php:`symbol` — Currency symbol (e.g. :php:`'€'`)

   .. php:method:: getBySymbol(string $symbol)

      Returns the first currency data array matching the given symbol, or :php:`null` if not found.

   .. php:method:: getAllIsoCodes()

      Returns an array of all available ISO 4217 alphabetic codes.

Usage examples
--------------

Resolving currency data from an event record::

   use DERHANSEN\SfEventMgt\Utility\CurrencyUtility;

   $currencyCode = $event->getCurrencyIso(); // e.g. 'EUR'
   $currency = CurrencyUtility::getByIsoCode($currencyCode);

   if ($currency !== null) {
       $symbol = $currency['symbol']; // '€'
       $numeric = $currency['numeric']; // '978'
       $name = $currency['name']; // 'Euro'
   }

Passing the numeric currency code to a payment provider API::

   $currency = CurrencyUtility::getByIsoCode($event->getCurrencyIso());
   $paymentRequest->setCurrencyCode($currency['numeric']);

Listing all supported ISO codes for a select field::

   $isoCodes = CurrencyUtility::getAllIsoCodes();
