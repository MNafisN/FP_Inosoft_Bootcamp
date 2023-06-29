import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            instructionData: {
                instruction_id: "",
                instruction_type: "Logistic Instruction",
                assigned_vendor: "test",
                vendor_address: "",
                attention_of: "",
                quotation_number: 0,
                invoice_to: "",
                customer_contact: "",
                cust_po_number: "",
                cost_detail: [
                    {
                        cost_description: "test",
                        quantity: 0,
                        unit_of_measurement: "SHP",
                        unit_price: 0,
                        GST_percentage: 0,
                        currency: "",
                        charge_to: ""
                    }
                ],
                attachment: [
                    {
                        name: 'file1.jpg',
                        info: 'by Irfan Faqih on 26/04/22 11:43 AM',
                        link: ''
                    }
                ],
                notes: null,
                transaction_code: "",
                invoices: [],
                termination: [],
                instruction_status: "Draft"
            }
        }
    },
    getters: {
        listCostTable(state) {
            return state.instructionData.cost_detail.length
        },
        getInstructionDetail(state){
            return {
                instruction_type: state.instructionData.instruction_type,
                assigned_vendor: state.instructionData.assigned_vendor,
                vendor_address: state.instructionData.vendor_address,
                attention_of: state.instructionData.attention_of,
                quotation_number: state.instructionData.quotation_number,
                invoice_to: state.instructionData.invoice_to,
                customer_contact: state.instructionData.customer_contact,
                cust_po_number: state.instructionData.cust_po_number
            }
        },
        getCostData: (state) => (index) => {
            return state.instructionData.cost_detail[index]
        },
        getAttachmentList(state) {
            return state.instructionData.attachment
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
                charge_to: ""
            })
        },
        deleteCostList(state, i) {
            state.instructionData.cost_detail.splice(i, 1)
        },
        updateCostList(state, payload) {
            state.instructionData.cost_detail[payload.i] = payload.data
        },
        addAttachment(state, payload) {
            state.instructionData.attachment.push(payload)
        }
    },
    actions: {
        uploadAttachment(context, payload) {
            context.commit('addAttachment', payload)
        }
    }
})

export default store