<template>
    <div>
        <div
          class="bg-[#1363DF] text-white p-2 mr-3 rounded-lg cursor-pointer"
          @click="openModal"
        >
            <ion-icon class="text-xl mr-2" name="print-outline"></ion-icon>
            Print
        </div>
        <Modal
            :is-open="isOpen.status"
            @close="closeModal"
            :btnSubmit="false"
        >
            <template #content>
                <div class="flex items-start rounded-lg px-3 md:p-5">
                    <slot name="content"></slot>
                </div>
                <div class="p-5 flex flex-col md:flex-row right-0 md:items-center justify-end bg-white">
                    <div>
                        <button
                            @click="isOpen?.type === 'excel' ? handleExportPDF(fileName, docTitle, isOpen.type) : handleExportPDF(fileName, docTitle, isOpen.type)"
                            class="mr-1 font-bold px-5 py-2 rounded-xl bg-[#1363DF] text-white"
                            :disabled="!dataExport?.isLoaded ? false : true"
                        >
                            {{!dataExport?.isLoaded ? 'Export' : 'Loading...' }}
                        </button>
                        <Select
                            style="{ width: 150 }"
                            class="ml-1 px-3 py-1 rounded-xl border-2 border-[#8C8CA1] text-white choose-select-export"
                            :value=isOpen?.type
                            @change="handleChangeOptionsExport"
                            :options="options"
                        />
                    </div>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script>
import { Select, DatePicker } from 'ant-design-vue'
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import Modal from './Modal.vue';
import ExcelJs from "exceljs";
import { formatDateYMD } from '../../helpers/function'

export default {
    components: {
        Select,
        Modal
    },
    props: {
        dataExport: Object,
        fileName: String,
        docTitle: String,
        type: String,
    },
    data() {
        return {
            columnArr : [],
            isOpen : {
                status: false,
                type: 'pdf'
            },
            options: [
                {
                    value: "pdf",
                    label: "PDF",
                },
                {
                    value: "csv",
                    label: "CSV",
                },
                {
                    value: "excel",
                    label: "EXCEL",
                }
            ],
        }
    },
    methods: {
        formatDateYMD,
        handleChangeOptionsExport(value) {
            this.isOpen.type = value
        },
        openModal() {
            this.isOpen.status = true;
        },
        closeModal() {
            this.isOpen.status = false;
        },
        handleExportPDF(fileName, docTitle, type) {
            if(type === 'pdf') {
                const pdf = new jsPDF();
                pdf.setFont('helvetica', 'normal');
                const htmlContent = ``;
                // const logo = new Image();
                // logo.src = '/assets/images/blkkconnectlogo.png';
                // pdf.addImage(logo, 'PNG', 15, 10, 60, 10);
                pdf.setFont('helvetica', 'bold');
                pdf.setFontSize(16);
                pdf.text(docTitle, 15, 35);
                pdf.setFontSize(8);
                pdf.setFont('helvetica', 'normal');

                const styles = {
                    theme: 'grid',
                    fontSize: 8,
                    overflow: 'linebreak',
                    columnWidth: 'auto',
                };

                pdf.autoTable({
                    head: this.dataExport?.head,
                    body: this.dataExport?.body,
                    startY: 50,
                    styles,
                });

                pdf.html(htmlContent, {
                    callback: function (pdf) {
                        // pdf.save('../../../src/documents/' + fileName + '.pdf');
                        window.open(pdf.output('bloburl'), '_blank');
                    },
                });
            }
            else if(type === 'csv') {
                const csvContent = "data:text/csv;charset=utf-8," +
                this.dataExport?.body?.map(row => Object.values(row).join(',')).join('\n');
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", fileName + ".csv");
                document.body.appendChild(link);
                link.click();
            }
            else if(type === 'excel') {
                this.exportToExcel(this.dataExport, fileName)
            }
        },
        exportToExcel(dataExport, fileName) {
            let sheetName = fileName + ".xlsx";
            let workbook = new ExcelJs.Workbook();
            let sheet = workbook.addWorksheet(sheetName, {
                views: [{ showGridLines: false }]
            });
            workbook.xlsx.writeBuffer().then((buffer) => {
                this.writeFile(sheetName, buffer);
            })
            let columnArr = []
            dataExport.head.map((v, i) => {
                columnArr.push({name: v})
            })
            let date = new Date();
            sheet.addTable({
                name: `Header`,
                ref: "A1",
                headerRow: true,
                totalsRow: false,
                columns: [{ name: "BLKK Connect" }],
                rows: [[`Tanggal: ${date}`], [``]]
            });

            sheet.addTable({
                name: 'Sheet1',
                ref: "A5",
                headerRow: true,
                totalsRow: false,
                columns: columnArr ? columnArr : [{ name: "" }],
                rows: dataExport.body.map((e) => {
                    let arr = [];
                    for (let i in e) {
                        arr.push(e[i]);
                    }
                    return arr;
                })
            });

            // sheet.columns = sheet.columns.map((e) => {
            //     const expr = e.values[5];
            //     switch (expr) {
            //         case "Name":
            //         return { width: 50 };
            //         case "Gender":
            //         return { width: 40 };
            //         case "Height":
            //         return { width: 30 };
            //         default:
            //         return { width: 20 };
            //     }
            // });

            // const table = sheet.getTable('Sheet1');
            // for (let i = 0; i < table.table.columns.length; i++) {
            //     sheet.getCell(`${String.fromCharCode(65 + i)}5`).font = { size: 12 };
            //     sheet.getCell(`${String.fromCharCode(65 + i)}5`).fill = {
            //         type: "pattern",
            //         pattern: "solid",
            //         fgColor: { argb: "c5d9f1" }
            //     };
            //     for (let j = 0; j < table.table.rows.length; j++) {
            //         let rowCell = sheet.getCell(`${String.fromCharCode(65 + i)}${j + 6}`);
            //         rowCell.alignment = { wrapText: true };
            //         rowCell.border = {
            //             bottom: {
            //                 color: { argb: "a6a6a6" }
            //             }
            //         };
            //     }
            // };

            table.commit();
            this.writeFile(fileName, content);
        },
        writeFile(fileName, content) {
            const link = document.createElement("a");
            const blob = new Blob([content], {
                type: "application/vnd.ms-excel;charset=utf-8;"
            });
            link.download = fileName;
            link.href = URL.createObjectURL(blob);
            link.click();
        },
    }
}
</script>
