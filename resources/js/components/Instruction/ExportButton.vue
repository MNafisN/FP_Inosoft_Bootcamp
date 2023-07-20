<template>
    <div class="position-absolute position">
        <button @click="download" class="tombol rounded"><div class="i-export"></div><span class="fw-bold">Export</span></button>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import axios from 'axios'
export default {
    name: "export-button",
    computed: {
        ...mapGetters({
            data: "getInstructionDetail",
            UsdCheck: "UsdCheck",
            AudCheck: "AudCheck",
            getUsdTotal: "getUsdTotal",
            getAudTotal: "getAudTotal"
        }),
        col1() {
            if(this.UsdCheck) {
                return {
                    currency: 'USD',
                    total: this.getUsdTotal.total
                }
            } else {
                return {
                    currency: 'AUD',
                    total: this.getAudTotal.total
                }
            }
        },
    },
    methods: {
        download() {
            const data = `
                <div>
                    <h1>TEAM 2 | ${this.data.instruction_type}</h1>
                    <table cellspacing='0' border='1' style='width: 100%;'>
                        <tr>
                            <td><b>Issue By</b></td>
                            <td><b>${this.data.issued_by}</b></td>
                            <td><b>Date of Issue</b></td>
                            <td><b>${this.data.date_of_issue}</b></td>
                        </tr>
                        <tr>
                            <td><b>LI Number/Rev</b></td>
                            <td colspan='3'>LI-12344</td>
                        </tr>
                        <tr>
                            <td><b>Customer</b></td>
                            <td>${this.data.customer_contact}</td>
                            <td><b>Customer PO</b></td>
                            <td>${this.data.cust_po_number}</td>
                        </tr>
                        <tr>
                            <td><b>Attention Of</b></td>
                            <td>${this.data.attention_of}</td>
                            <td><b>Vendor Quotation</b></td>
                            <td>${this.data.quotation_number}</td>
                        </tr>
                        <tr>
                            <td><b>Issue To</b></td>
                            <td>${this.data.assigned_vendor}</td>
                            <td><b>Invoice To</b></td>
                            <td>${this.data.invoice_to}</td>
                        </tr>
                        <tr>
                            <td><b>Vendor Address</b></td>
                            <td colspan='3'>${this.data.vendor_address}</td>
                        </tr>
                    </table>
                    <br>
                    <table cellspacing='0' border='1' style='width: 100%;'>
                        <tr>
                            <td colspan='7' class='center'><b>Details Of Cost</b></td>
                        </tr>
                        <tr>
                            <td class='center'>Description</td>
                            <td class='center'>Quantity</td>
                            <td class='center'>UOM</td>
                            <td class='center'>Unit Price</td>
                            <td class='center'>GST(%)</td>
                            <td class='center'>Currency</td>
                            <td class='center'>Total</td>
                        </tr>
                        ${this.data.cost_detail.map((cost)=>(
                            '<tr>'+
                                '<td>'+cost.cost_description+'</td>'+
                                '<td class="right">'+cost.quantity+'</td>'+
                                '<td>'+cost.unit_of_measurement+'</td>'+
                                '<td class="right">'+cost.unit_price+'</td>'+
                                '<td class="right">'+cost.GST_percentage+'</td>'+
                                '<td>'+cost.currency+'</td>'+
                                '<td class="right">'+cost.total+'</td>'
                            +'</tr>'
                        ))}
                        <tr>
                            <td colspan='4'></td>
                            <td class='right'><b>Grand Total</b></td>
                            <td>${this.col1.currency}</td>
                            <td class="right">${this.col1.total}</td>
                        </tr>
                        ${this.AudCheck ?
                        '<tr>'+
                            '<td colspan="5"></td>'+
                            '<td>AUD</td>'+
                            '<td class="right">'+this.getAudTotal.total +'</td>'
                        +'</tr>'
                        : null}
                    </table>
                    <br>
                    <p><b>INSTRUCTION NOTES</b></p>
                    ${this.data.notes ? this.data.notes : 'Notes'}
                </div>
                <style>
                    td {
                        border: 1px solid black;
                        height: 30px;
                        margin: 0;
                        padding: 0 5px;
                    }
                    .center{
                        text-align: center;
                    }
                    .right{
                        text-align: right;
                    }
                </style>

            `;
            axios.post('/api/instruction/exportPDF', {view: "app", html: data}, {responseType: "blob"})
            .then((response) => {
                var fileURL = window.URL.createObjectURL( new Blob([response.data]) );
                var fileLink = document.createElement("a");

                fileLink.href = fileURL;
                fileLink.setAttribute("download", 'exportPDF.pdf');
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },

    },
};
</script>
<style scoped>
.position{
    right: 35px;
    top: 120px;
}
.tombol{
    width: 100px;
    height: 30px;
    background-color: white;
    border: 1px solid rgba(0, 0, 0, 0.377);
}
</style>
