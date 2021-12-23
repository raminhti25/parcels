import React, { useState } from 'react'
import {
    CCard,
    CCardBody,
    CCardGroup,
    CCol,
    CContainer,
    CRow,
} from '@coreui/react'
import axios from "axios";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import './custom.css';

const NewParcel = (props) => {

    const [pickUpAddress, setPickUpAddress] = useState('');
    const [dropOffAddress, setDropOffAddress] = useState('');
    const [recipientMobile, setRecipientMobile] = useState('');
    const [weight, setWeight] = useState('');
    const [note, setNote] = useState('');

    const pickUpAddressChangeHandler = event => {
        setPickUpAddress(event.target.value);
    };

    const dropOffAddressChangeHandler = event => {
        setDropOffAddress(event.target.value);
    };

    const recipientMobileChangeHandler = event => {
        setRecipientMobile(event.target.value);
    };

    const weightHandler = event => {
        setWeight(event.target.value);
    };

    const noteHandler = event => {
      setNote(event.target.value);
    };

    const submitHandler = (event) => {

        event.preventDefault();

        const accessToken = localStorage.getItem('accessToken');

        const data = {
            pick_up_address: pickUpAddress,
            drop_off_address: dropOffAddress,
            recipient_mobile: recipientMobile,
            details: {weight: weight, note: note}
        };

        axios.post('http://localhost:8000/api/parcels', data, {headers: {Authorization: 'Bearer ' + accessToken}})
            .then((response) => {
                setPickUpAddress('');
                setDropOffAddress('');
                setRecipientMobile('');
                setWeight('');
                setNote('');
                toast("Parcel created");
                props.history.push('/sender-parcels')
            })
            .catch(function(err){
                toast.error(err.response.data.message);
            });

    };

    const cancelHandler = () => {
        props.history.push('/sender-parcels')
    };

    return (
        <div className="bg-light min-vh-100 d-flex flex-row align-items-center">
            <CContainer>
                <CRow className="justify-content-center">
                    <CCol md={8}>
                        <CCardGroup>
                            <CCard className="p-4">
                                <CCardBody>
                                    <h1>New Parcel</h1>
                                    <form onSubmit={submitHandler}>
                                        <div>
                                            <label>Pick-up Address <span className="required-icon">*</span></label>
                                            <input
                                                type="text"
                                                value={pickUpAddress}
                                                required
                                                max="255"
                                                onChange={pickUpAddressChangeHandler}
                                            />
                                        </div>
                                        <div>
                                            <label>Drop-off Address <span className="required-icon">*</span></label>
                                            <input
                                                type="text"
                                                value={dropOffAddress}
                                                required
                                                max="255"
                                                onChange={dropOffAddressChangeHandler}
                                            />
                                        </div>
                                        <div>
                                            <label>Recipient Mobile <span className="required-icon">*</span></label>
                                            <input
                                                type="text"
                                                value={recipientMobile}
                                                required
                                                max="21"
                                                onChange={recipientMobileChangeHandler}
                                                placeholder="+98123456789"
                                            />
                                        </div>
                                        <div>
                                            <label>Weight(Gram)</label>
                                            <input
                                                type="number"
                                                value={weight}
                                                min="0"
                                                onChange={weightHandler}
                                            />
                                        </div>
                                        <div>
                                            <label>Note</label>
                                            <div>
                                                <textarea value={note} onChange={noteHandler} />
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" className="button bg-blue">Create</button>
                                            <button className="button cancel-button" onClick={cancelHandler}>Cancel</button>
                                        </div>
                                    </form>
                                    <ToastContainer/>
                                </CCardBody>
                            </CCard>
                        </CCardGroup>
                    </CCol>
                </CRow>
            </CContainer>
        </div>
    )
};

export default NewParcel
