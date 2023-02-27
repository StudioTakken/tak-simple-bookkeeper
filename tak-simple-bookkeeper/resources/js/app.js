import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import PerfectScrollbar from 'perfect-scrollbar'


window.PerfectScrollbar = PerfectScrollbar

document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0
        const init = function () {
            window.addEventListener('scroll', () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true
                    this.scrollingUp = false
                } else {
                    // upscroll
                    this.scrollingDown = false
                    this.scrollingUp = true
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false
                        this.scrollingUp = false
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st // For Mobile or negative scrolling
            })
        }

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }
        const getSidebar = () => {

            if (window.localStorage.getItem('isSidebarOpen')) {
                return JSON.parse(window.localStorage.getItem('isSidebarOpen'))
            }

        }
        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }
        const setSidebar = (value) => {
            window.localStorage.setItem('isSidebarOpen', value)
        }
        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode
                setTheme(this.isDarkMode)
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarOpen: getSidebar(),
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                } else {
                    this.isSidebarOpen = true
                }
               
            },
            
            toggleSidebar() { 
                this.isSidebarOpen = !this.isSidebarOpen
                setSidebar(this.isSidebarOpen)               
            },

            scrollingDown: false,
            scrollingUp: false,
        }
    })
})

window.Alpine = Alpine
Alpine.plugin(collapse)


Alpine.start()
