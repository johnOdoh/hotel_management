(function() {
    function registerExporter() {
        if (!window.Alpine) return;
        window.Alpine.data('workScheduleExporter', () => ({
            exporting: false,
            downloadCalendar(selectedPosition, startOfWeekDate) {
                this.exporting = true;
                const exportArea = document.getElementById('calendar-export-area');
                if (!exportArea) {
                    this.exporting = false;
                    return;
                }

                const self = this;
                const fileName = `Work_Schedule_${selectedPosition}_${startOfWeekDate}.png`;

                this.loadDomToImage(() => {
                    const isDark = document.documentElement.classList.contains('dark');
                    const bgColor = isDark ? '#111827' : '#ffffff';

                    const filter = (node) => {
                        if (!node || !node.classList) return true;
                        if (node.getAttribute && node.getAttribute('data-html2canvas-ignore') === 'true') return false;
                        if (node.classList.contains('no-export')) return false;
                        return true;
                    };

                    const scale = 2;
                    const options = {
                        filter: filter,
                        bgcolor: bgColor,
                        width: exportArea.offsetWidth * scale,
                        height: exportArea.offsetHeight * scale,
                        style: {
                            transform: `scale(${scale})`,
                            transformOrigin: 'top left',
                            width: exportArea.offsetWidth + 'px',
                            height: exportArea.offsetHeight + 'px'
                        }
                    };

                    window.domtoimage.toPng(exportArea, options)
                        .then(function(dataUrl) {
                            const link = document.createElement('a');
                            link.download = fileName;
                            link.href = dataUrl;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            self.exporting = false;
                        })
                        .catch(function(err) {
                            console.warn('dom-to-image failed, trying html2canvas fallback:', err);
                            self.fallbackHtml2Canvas(exportArea, fileName, selectedPosition);
                        });
                }, () => {
                    self.fallbackHtml2Canvas(exportArea, fileName, selectedPosition);
                });
            },
            loadDomToImage(onSuccess, onError) {
                if (window.domtoimage) {
                    return onSuccess();
                }
                const script = document.createElement('script');
                script.src = window.location.origin + '/js/dom-to-image.min.js';
                script.onload = () => {
                    if (window.domtoimage) onSuccess();
                    else onError();
                };
                script.onerror = onError;
                document.head.appendChild(script);
            },
            fallbackHtml2Canvas(exportArea, fileName, selectedPosition) {
                const self = this;
                const isDark = document.documentElement.classList.contains('dark');
                const bgColor = isDark ? '#111827' : '#ffffff';

                if (window.html2canvas) {
                    window.html2canvas(exportArea, {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: bgColor,
                        logging: false,
                        ignoreElements: function(element) {
                            return element.getAttribute('data-html2canvas-ignore') === 'true' || element.classList.contains('no-export');
                        }
                    }).then(function(canvas) {
                        const link = document.createElement('a');
                        link.download = fileName;
                        link.href = canvas.toDataURL('image/png');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        self.exporting = false;
                    }).catch(function(err) {
                        console.warn('All canvas exports failed, opening landscape print view:', err);
                        self.exporting = false;
                        self.printOnlySchedule(selectedPosition);
                    });
                } else {
                    const script = document.createElement('script');
                    script.src = window.location.origin + '/js/html2canvas.min.js';
                    script.onload = () => self.fallbackHtml2Canvas(exportArea, fileName, selectedPosition);
                    script.onerror = () => {
                        self.exporting = false;
                        self.printOnlySchedule(selectedPosition);
                    };
                    document.head.appendChild(script);
                }
            },
            printOnlySchedule(selectedPosition) {
                const exportArea = document.getElementById('calendar-export-area');
                if (!exportArea) return;

                const printWindow = window.open('', '_blank', 'width=1200,height=800');
                if (!printWindow) {
                    window.print();
                    return;
                }

                let styles = '';
                document.querySelectorAll('link[rel="stylesheet"], style').forEach(node => {
                    styles += node.outerHTML;
                });

                printWindow.document.open();
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Work Schedule - ${selectedPosition}</title>
                        ${styles}
                        <style>
                            @page {
                                size: landscape;
                                margin: 8mm;
                            }
                            * {
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                                color-adjust: exact !important;
                            }
                            body {
                                background: white !important;
                                color: black !important;
                                padding: 10px !important;
                                font-family: inherit;
                            }
                            .no-export, [data-html2canvas-ignore] {
                                display: none !important;
                            }
                            #calendar-export-area {
                                border: 1px solid #e5e7eb !important;
                                box-shadow: none !important;
                                width: 100% !important;
                            }
                            #calendar-export-area .grid {
                                display: grid !important;
                                grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
                                gap: 8px !important;
                            }
                        </style>
                    </head>
                    <body>
                        <div id="calendar-export-area" class="p-3">
                            ${exportArea.innerHTML}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();

                setTimeout(() => {
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                }, 400);
            }
        }));
    }

    if (window.Alpine) {
        registerExporter();
    } else {
        document.addEventListener('alpine:init', registerExporter);
    }
})();
