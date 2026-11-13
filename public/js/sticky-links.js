/*
 * Sticky-Links (tonsinn/sticky-links-bundle)
 *
 * Steuert die Panels der Leiste: Öffnen per Klick oder Tastatur, auf Geräten
 * mit Maus zusätzlich per Hover; Schließen per Escape, Schließen-Schaltfläche
 * oder Klick außerhalb. Es ist immer nur ein Panel geöffnet.
 *
 * Ohne dieses Skript öffnen die Panels per CSS (:hover, :focus-within).
 */
(function () {
    'use strict';

    var OPEN_DELAY = 120;
    var CLOSE_DELAY = 350;

    function init(bar) {
        if (bar.hasAttribute('data-stickylinks-init')) {
            return;
        }

        var items = Array.prototype.slice.call(bar.querySelectorAll('[data-stickylinks-item="panel"]'));
        var canHover = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        var openItem = null;
        var pinned = false;
        var timer = null;

        bar.setAttribute('data-stickylinks-init', '');

        function trigger(item) {
            return item.querySelector('.stickylinks__trigger');
        }

        function close(restoreFocus) {
            window.clearTimeout(timer);

            if (!openItem) {
                return;
            }

            var button = trigger(openItem);

            openItem.classList.remove('is-open');
            button.setAttribute('aria-expanded', 'false');

            if (restoreFocus && openItem.contains(document.activeElement)) {
                button.focus();
            }

            openItem = null;
            pinned = false;
        }

        function open(item, pin) {
            window.clearTimeout(timer);

            if (openItem && openItem !== item) {
                close(false);
            }

            openItem = item;
            pinned = pin;
            item.classList.add('is-open');
            trigger(item).setAttribute('aria-expanded', 'true');
        }

        items.forEach(function (item) {
            var button = trigger(item);

            if (!button) {
                return;
            }

            button.addEventListener('click', function () {
                // Ein per Hover geöffnetes Panel wird durch den Klick fixiert,
                // nicht geschlossen.
                if (openItem === item && pinned) {
                    close(false);
                } else {
                    open(item, true);
                }
            });

            var closeButton = item.querySelector('[data-stickylinks-close]');

            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    close(true);
                });
            }

            if (canHover) {
                item.addEventListener('mouseenter', function () {
                    window.clearTimeout(timer);

                    if (openItem === item) {
                        return;
                    }

                    // Ein fixiertes Panel wird nicht durch bloßes Überfahren ersetzt
                    if (openItem && pinned) {
                        return;
                    }

                    timer = window.setTimeout(function () {
                        open(item, false);
                    }, OPEN_DELAY);
                });

                item.addEventListener('mouseleave', function () {
                    window.clearTimeout(timer);

                    if (openItem === item && !pinned) {
                        timer = window.setTimeout(function () {
                            close(false);
                        }, CLOSE_DELAY);
                    }
                });
            }
        });

        document.addEventListener('keydown', function (event) {
            if ('Escape' === event.key && openItem) {
                close(true);
            }
        });

        document.addEventListener('click', function (event) {
            if (openItem && !openItem.contains(event.target)) {
                close(false);
            }
        });

        // Verlässt der Tastaturfokus das geöffnete Panel, wird es geschlossen
        bar.addEventListener('focusout', function (event) {
            if (openItem && event.relatedTarget && !openItem.contains(event.relatedTarget)) {
                close(false);
            }
        });
    }

    function initAll() {
        Array.prototype.forEach.call(document.querySelectorAll('[data-stickylinks]'), init);
    }

    if ('loading' === document.readyState) {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
