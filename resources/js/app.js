import './bootstrap'

import Alpine from 'alpinejs'
import Cookies from 'js-cookie'
import Chart from 'chart.js/auto'

window.Chart = Chart
window.Alpine = Alpine

Alpine.data('affiliate', () => ({
    affiliate: null,
    via: new URL(location.href).searchParams.get('via'),

    init() {
        const cookie = JSON.parse(atob(Cookies.get('affiliate')))

        if (! this.via && Cookies.get('affiliate')) {
            // If there's a cookie present, we will still be remembering the guest
            window.location.href = `${(window.location.href)}?via=${cookie.code}`

            return
        }

        if (Cookies.get('affiliate')) {
            this.affiliate = cookie
        }
    }
}))

Alpine.start()
