document.addEventListener(
    'DOMContentLoaded',
    function () {

        document.body.classList.add('loaded');


        /*
        |--------------------------------------------------------------------------
        | Mobile Menu
        |--------------------------------------------------------------------------
        */

        const menuToggle =
            document.getElementById(
                'menuToggle'
            );

        const mainNav =
            document.getElementById(
                'mainNav'
            );


        if (
            menuToggle &&
            mainNav
        ) {

            menuToggle.addEventListener(
                'click',
                function () {

                    mainNav.classList.toggle(
                        'open'
                    );

                }
            );


            mainNav
                .querySelectorAll('a')
                .forEach(
                    function (link) {

                        link.addEventListener(
                            'click',
                            function () {

                                mainNav.classList.remove(
                                    'open'
                                );

                            }
                        );

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Page Transition
        |--------------------------------------------------------------------------
        |
        | Keep the effect, but make it almost instant.
        |
        */

        document
            .querySelectorAll('a')
            .forEach(
                function (link) {

                    const href =
                        link.getAttribute(
                            'href'
                        );


                    if (!href) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Skip special / external / admin links
                    |--------------------------------------------------------------------------
                    */

                    if (
                        href.startsWith('#') ||
                        href.startsWith('mailto:') ||
                        href.startsWith('tel:') ||
                        href.startsWith('javascript:') ||
                        link.target === '_blank' ||
                        href.includes('/admin/')
                    ) {

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | External URL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        link.hostname &&
                        link.hostname !==
                            window.location.hostname
                    ) {

                        return;
                    }


                    link.addEventListener(
                        'click',
                        function (event) {

                            const transition =
                                document.querySelector(
                                    '.page-transition'
                                );


                            if (!transition) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Don't delay modified clicks
                            |--------------------------------------------------------------------------
                            */

                            if (
                                event.ctrlKey ||
                                event.metaKey ||
                                event.shiftKey ||
                                event.altKey
                            ) {

                                return;
                            }


                            event.preventDefault();


                            transition.classList.add(
                                'active'
                            );


                            setTimeout(
                                function () {

                                    window.location.href =
                                        href;

                                },
                                160
                            );

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Header Background
        |--------------------------------------------------------------------------
        */

        const header =
            document.querySelector(
                '.site-header'
            );


        if (header) {

            const updateHeader =
                function () {

                    if (
                        window.scrollY > 40
                    ) {

                        header.classList.add(
                            'scrolled'
                        );

                    } else {

                        header.classList.remove(
                            'scrolled'
                        );

                    }

                };


            updateHeader();


            window.addEventListener(
                'scroll',
                updateHeader,
                {
                    passive: true
                }
            );

        }

    }
);