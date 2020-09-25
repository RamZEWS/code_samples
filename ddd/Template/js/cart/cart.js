export class Cart {
    constructor() {
        this.addToCartSelector = '[data-behavior="add-to-cart"]';
        this.removeFromCartSelector = '[data-behavior="remove-from-cart"]';
        this.plusOneProductSelector = '[data-behavior="plus-one-product"]';
        this.minusOneProductSelector = '[data-behavior="minus-one-product"]';
    }

    init() {
        this._addToCartEvent();
        this._removeFromCart();
        this._plusProductToCartEvent();
        this._minusProductToCartEvent();
    }

    _addToCartEvent() {
        $(document).on('click', this.addToCartSelector, (e) => {
            let button = $(e.currentTarget);

            let productId = this._getProductIdFromButton(button);
            if (isNaN(productId)) {
                return;
            }

            $.ajax({
                url: `/api/add-to-cart/${productId}/`,
                type: 'POST',
                success: (data) => {
                    console.log(data);

                    if (data.hasOwnProperty('isSuccess') && data.isSuccess) {
                        alert('Добавлено');
                    } else {
                        alert('Ошибка');
                    }
                }
            });
        });
    }

    _removeFromCart() {
        $(document).on('click', this.removeFromCartSelector, (e) => {
            let button = $(e.currentTarget);

            let productId = this._getProductIdFromButton(button);
            if (isNaN(productId)) {
                return;
            }

            $.ajax({
                url: `/api/remove-from-cart/${productId}/`,
                type: 'DELETE',
                success: (data) => {
                    console.log(data);

                    if (data.hasOwnProperty('isSuccess') && data.isSuccess) {
                        alert('Удалено');
                    } else {
                        alert('Ошибка');
                    }
                }
            });
        });
    }

    _plusProductToCartEvent() {
        $(document).on('click', this.plusOneProductSelector, (e) => {
            let button = $(e.currentTarget);

            let productId = this._getProductIdFromButton(button);
            if (isNaN(productId)) {
                return;
            }

            $.ajax({
                url: `/api/plus-product-to-cart/${productId}/`,
                type: 'POST',
                success: (data) => {
                    console.log(data);

                    if (data.hasOwnProperty('isSuccess') && data.isSuccess) {
                        alert('Плюс 1');
                    } else {
                        alert('Ошибка');
                    }
                }
            });
        });
    }

    _minusProductToCartEvent() {
        $(document).on('click', this.addToCartSelector, (e) => {
            let button = $(e.currentTarget);

            let productId = this._getProductIdFromButton(button);
            if (isNaN(productId)) {
                return;
            }

            $.ajax({
                url: `/api/plus-product-to-cart/${productId}/`,
                type: 'POST',
                success: (data) => {
                    console.log(data);

                    if (data.hasOwnProperty('isSuccess') && data.isSuccess) {
                        alert('Минус 1');
                    } else {
                        alert('Ошибка');
                    }
                }
            });
        });
    }

    _getProductIdFromButton(button) {
        let productId = button.data('product-id');

        return Number(productId);
    }
}
