import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            instructionData: {
                instruction_id: "test",
                instruction_type: "Logistic Instruction",
                assigned_vendor: "test",
                vendor_address: "vendor vendoran",
                attention_of: "anu",
                quotation_number: 0,
                invoice_to: "yg maha kuasa",
                customer_contact: "08sakteruse",
                cust_po_number: "abc-123",
                cost_detail: [
                    {
                        cost_description: "test",
                        quantity: 0,
                        unit_of_measurement: "SHP",
                        unit_price: 0,
                        GST_percentage: 0,
                        currency: "",
                        vat_amount: 0,
                        sub_total: 0,
                        total: 0,
                        charge_to: "",
                    },
                ],
                attachment: [
                    {
                        name: "file1.jpg",
                        info: "by Irfan Faqih on 26/04/22 11:43 AM",
                        link: "",
                    },
                ],
                notes: null,
                transaction_code: "",
                invoices: [
                    {
                        invoice_no: "AAL-008",
                        invoice_attachment: {
                            name: "AAL-008",
                            link: ""
                        },
                        supporting_document: [
                            {
                                name: 'ABC-001',
                                link: ""
                            },
                            {
                                name: 'ABC-001',
                                link: ""
                            },
                        ]
                    },
                    {
                        invoice_no: "AAL-008",
                        invoice_attachment: {
                            name: "AAL-008",
                            link: ""
                        },
                        supporting_document: [
                            {
                                name: 'ABC-001',
                                link: ""
                            },
                            {
                                name: 'ABC-001',
                                link: ""
                            },
                        ]
                    },
                ],
                termination: [],
                instruction_status: "Draft",
            },
            link_to: "",
            internalOnly: {
                attachment: [
                    {
                        name: "file1.jpg",
                        info: "by Irfan Faqih on 26/04/22 11:43 AM",
                        link: "",
                    },
                ],
                notes: []
            }
        };
    },
    getters: {
        listCostTable(state) {
            return state.instructionData.cost_detail.length;
        },
        getInstructionDetail(state) {
            return {
                instruction_type: state.instructionData.instruction_type,
                assigned_vendor: state.instructionData.assigned_vendor,
                vendor_address: state.instructionData.vendor_address,
                attention_of: state.instructionData.attention_of,
                quotation_number: state.instructionData.quotation_number,
                invoice_to: state.instructionData.invoice_to,
                customer_contact: state.instructionData.customer_contact,
                cust_po_number: state.instructionData.cust_po_number,
                instruction_status: state.instructionData.instruction_status
            };
        },
        getCostData: (state) => (index) => {
            return state.instructionData.cost_detail[index];
        },
        getAttachmentList(state) {
            return state.instructionData.attachment;
        },
        getUsdTotal(state) {
            const vat_amount = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "USD") {
                        return a + b.vat_amount;
                    } else {
                        return a;
                    }
                },
                0
            );
            const sub_total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "USD") {
                        return a + b.sub_total;
                    } else {
                        return a;
                    }
                },
                0
            );
            const total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "USD") {
                        return a + b.total;
                    } else {
                        return a;
                    }
                },
                0);

            return {
                vat_amount,
                sub_total,
                total
            };
        },
        getAudTotal(state) {
            const vat_amount = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "AUD") {
                        return a + b.vat_amount;
                    } else {
                        return a;
                    }
                },
                0
            );
            const sub_total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "AUD") {
                        return a + b.sub_total;
                    } else {
                        return a;
                    }
                },
                0
            );
            const total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "AUD") {
                        return a + b.total;
                    } else {
                        return a;
                    }
                },
                0);

            return {
                vat_amount,
                sub_total,
                total,
                data: state.instructionData.cost_detail,
            };
        },
        UsdCheck(state) {
            return state.instructionData.cost_detail.some(
                function(cost) {
                    return cost.currency === "USD"
                }
            )
        },
        AudCheck(state) {
            return state.instructionData.cost_detail.some(
                function(cost) {
                    return cost.currency === "AUD"
                }
            )
        },
        getLinkTo(state) {
            return state.link_to
        },
        getVendorInvoiceData(state) {
            return state.instructionData.invoices
        },
        getAttachmentInternalList(state) {
            return state.internalOnly.attachment
        }
    },
    mutations: {
        addCostList(state) {
            state.instructionData.cost_detail.push({
                cost_description: "",
                quantity: 0,
                unit_of_measurement: "SHP",
                unit_price: 0,
                GST_percentage: 0,
                currency: "",
                vat_amount: 0,
                sub_total: 0,
                total: 0,
                charge_to: "",
            });
        },
        deleteCostList(state, i) {
            state.instructionData.cost_detail.splice(i, 1);
        },
        updateCostDescription(state, payload) {
            state.instructionData.cost_detail[payload.i].cost_description =
                payload.data;
        },
        updateCostQuantity(state, payload) {
            state.instructionData.cost_detail[payload.i].quantity = parseInt(
                payload.data
            );
            this.commit("updateCostTotal", payload.i);
        },
        updateCostUOM(state, payload) {
            state.instructionData.cost_detail[payload.i].unit_of_measurement =
                payload.data;
        },
        updateCostUnitPrice(state, payload) {
            state.instructionData.cost_detail[payload.i].unit_price =
                parseFloat(payload.data);
            this.commit("updateCostTotal", payload.i);
        },
        updateCostGST(state, payload) {
            state.instructionData.cost_detail[payload.i].GST_percentage =
                parseFloat(payload.data);
            this.commit("updateCostTotal", payload.i);
        },
        updateCostCurrency(state, payload) {
            state.instructionData.cost_detail[payload.i].currency =
                payload.data;
        },
        updateCostChargeTo(state, payload) {
            state.instructionData.cost_detail[payload.i].charge_to =
                payload.data;
        },
        updateCostTotal(state, i) {
            const data = state.instructionData.cost_detail[i];
            data.vat_amount =
                Math.round(
                    ((data.unit_price * data.quantity * data.GST_percentage) /
                        100) *
                        100
                ) / 100;
            data.sub_total =
                Math.round(data.unit_price * data.quantity * 100) / 100;
            data.total =
                Math.round((data.vat_amount + data.sub_total) * 100) / 100;
        },
        addAttachment(state, payload) {
            state.instructionData.attachment.push(payload);
        },
        updateLinkTo(state, payload) {
            state.link_to = payload
        },
        removeLinkTo(state) {
            state.link_to = ""
        },
        uploadAttachmentInternal(state, payload) {
            state.internalOnly.attachment.push(payload)
        },
    },
    actions: {
    },
});

export default store;
