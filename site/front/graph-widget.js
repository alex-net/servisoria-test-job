jQuery(function() {
    $('.graph-widget-container').each((ind, el) => {
        let dataVar = $(el).data('view-var');

        let labels = Object.keys(window[dataVar].data);
        let data = Object.values(window[dataVar].data);
        let lines = Object.keys(data[0]);
        let datasets = [];
        lines.forEach(el => {
            let ds = [];
            labels.forEach(lab => {
                ds.push(window[dataVar].data[lab][el]);
            });

            datasets.push({
                label: window[dataVar].lineTitle.replace('{*}', window[dataVar].descr[el.replace('line', '')]),
                data: ds,
                borderWidth: 1,
            })
        });

        let options = {
            plugins:{},
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
        if (window[dataVar].caption) {
            options.plugins.title = {
                display: true,
                text: window[dataVar].caption,
            }
        }

        new Chart(el, {
            type: 'line',
            data: {
              labels,
              datasets
            },
            options
          });



    });
});