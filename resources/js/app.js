import './bootstrap'

import Alpine from 'alpinejs'
import Cookies from 'js-cookie'

window.Alpine = Alpine

Alpine.data('affiliate', () => ({
    affiliate: null,
    via: new URL(location.href).searchParams.get('via'),

    init() {
        if (! this.via && Cookies.get('affiliate')) {
            // When user wants to create different account, old affiliate cookie might be present
            return Cookies.remove('affiliate')
        }

        if (Cookies.get('affiliate')) {
            this.affiliate = JSON.parse(atob(Cookies.get('affiliate')))
        }
    }
}))

Alpine.start()
