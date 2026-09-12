document.addEventListener('DOMContentLoaded', function () {

    const elements =
        document.querySelectorAll('.reveal');

    if (!elements.length) {
        return;
    }

    const observer =
        new IntersectionObserver(
            function (entries, observer) {

                entries.forEach(function (entry) {

                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add(
                        'visible'
                    );

                    observer.unobserve(
                        entry.target
                    );

                });

            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -50px 0px'
            }
        );

    elements.forEach(function (element) {
        observer.observe(element);
    });

});