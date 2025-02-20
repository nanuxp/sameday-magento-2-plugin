define(
    [
        'mage/translate',
        'Magento_Ui/js/model/messageList',
        'Magento_Checkout/js/model/quote',
    ],
    function ($t, messageList, quote) {
        'use strict';
        return {
            validate: function () {
                const lockerServiceCode = 'LN';
                const samedayCourierLocker = 'samedaycourier_locker';

                let isValid = true;

                // Get current selected locker from cookie.
                const getCookie = (key) => {
                    let cookie = '';
                    document.cookie.split(';').forEach(function (value) {
                        if (value.split('=')[0].trim() === key) {
                            return cookie = value.split('=')[1];
                        }
                    });

                    return cookie;
                }

                let method = quote.shippingMethod();

                if (null !== method) {
                    if (lockerServiceCode === method.method_code) {
                        let locker = getCookie(samedayCourierLocker);
                        if ('' === locker) {
                            isValid = false;
                        } else {
                            locker = JSON.parse(locker);
                            if (undefined === locker.name) {
                                isValid = false;
                            }
                        }
                    }
                } else {
                    return isValid;
                }

                if (!isValid) {
                    messageList.addErrorMessage({ message: $t('Please select your Easybox!') });
                }

                return isValid;
            }
        }
    }
);
