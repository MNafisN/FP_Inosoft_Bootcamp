import axios from "axios";
import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            instructionData: {
                instruction_id: "",
                instruction_type: "Logistic Instruction",
                assigned_vendor: "",
                vendor_address: "",
                attention_of: "",
                quotation_number: 0,
                invoice_to: "",
                customer_contact: "",
                cust_po_number: "",
                cost_detail: [
                    {
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
                invoices: [],
                termination: {
                    user: "User",
                    description: "Test",
                    attachment: []
                },
                instruction_status: "Draft",
            },
            internalOnly: {
                attachment: [
                    {
                        name: "file1.jpg",
                        info: "by Irfan Faqih on 26/04/22 11:43 AM",
                        link: "",
                    },
                ],
                notes: [
                    {
                        value: "ini adalah contoh untuk notes",
                        user: "User",
                        time: "08/07/23 05:12 PM"
                    }
                ]
            },
            formData: {
                customers: [],
                transactions: [],
                vendors: []
            }
        };
    },
    getters: {
        getStatus(state) {
            return state.instructionData.instruction_status
        },
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
        getTransactionCode(state) {
            return state.instructionData.transaction_code
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
        getVendorInvoiceAll(state) {
            return state.instructionData.invoices
        },
        getVendorInvoice: (state)=> (index)=> {
            return state.instructionData.invoices[index]
        },
        getAttachmentInternalOnly(state) {
            return state.internalOnly.attachment
        },
        getNotesInternalOnlyAll(state) {
            return state.internalOnly.notes
        },
        getNotesInternalOnly: (state)=> (index)=> {
            return state.internalOnly.notes[index].value
        },
        getAttachmentTerminate(state) {
            return state.instructionData.termination.attachment
        },
        getFormData(state) {
            return state.formData
        }
    },
    mutations: {
        updateStatus(state, payload) {
            state.instructionData.instruction_status = payload
        },
        updateInstructionType(state, payload) {            
            state.instructionData.instruction_type = payload
        },
        updateAssignedVendor(state, payload) {
            state.instructionData.assigned_vendor = payload
        },
        updateVendorAddress(state, payload) {
            state.instructionData.vendor_address = payload
        },
        updateAttentionOf(state, payload) {
            state.instructionData.attention_of = payload
        },
        updateQuotationNumber(state, payload) {
            state.instructionData.quotation_number = payload
        },
        updateInvoiceTo(state, payload) {
            state.instructionData.invoice_to = payload
        },
        updateCustomerContract(state, payload) {
            state.instructionData.customer_contact = payload
        },
        updatePoNumber(state, payload) {
            state.instructionData.cust_po_number = payload
        },
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
        addInvoices(state, payload) {
            state.instructionData.invoices.push(payload)
        },
        deleteInvoice(state, i) {
            state.instructionData.invoices.splice(i,1)
        },
        updateInvoice(state, payload) {
            state.instructionData.invoices[payload.index] = payload.invoice
            console.log('edit invoice');
        },
        addAttachmentInternalOnly(state, payload) {
            state.internalOnly.attachment.push(payload)
        },
        deleteAttachmentInternalOnly(state, i) {
            state.internalOnly.attachment.splice(i, 1)
        },
        addNotesInternalOnly(state, payload) {
            state.internalOnly.notes.push(payload)
        },
        deleteNotesInternalOnly(state, i) {
            state.internalOnly.notes.splice(i, 1)
        },
        updateNotesInternalOnly(state, payload) {
            state.internalOnly.notes[payload.index] = payload.data
        },
        addAttachmentTerminate(state, payload) {
            state.instructionData.termination.attachment.push(payload)
        },
        deleteAttachmentTerminate(state, i) {
            state.instructionData.termination.attachment.splice(i, 1)
        },
        terminateInstruction(state, payload) {
            state.instructionData.termination.user = payload.user
            state.instructionData.termination.description = payload.description
            state.instructionData.instruction_status = "Canceled"
        },
        setFormData(state, payload) {
            state.formData = payload
        }
    },
    actions: {
        async getFormData(context) {
            const data = (await axios.get('http://127.0.0.1:8000/api/instruction/addNew')).data
            context.commit('setFormData', await data.form_data)
            console.log(data);
        }
    },
});

export default store;
