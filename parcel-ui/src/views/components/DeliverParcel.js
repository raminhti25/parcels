import React, { useState, useEffect } from 'react';
import axios from "axios";
import {CCard, CCardBody, CCardGroup, CCol, CContainer, CRow} from "@coreui/react";
import {toast, ToastContainer} from "react-toastify";
import './custom.css';

const DeliverParcel = (props) => {

    let d = new Date();

    let now_date = d.getFullYear() + '-' + (d.getMonth()+1) + "-" +  (d.getDate() < 10 ? '0' : '') + d.getDate();
    let now_time = (d.getHours()) + ":" + d.getMinutes();

    const [parcel, setParcel] = useState({});
    const [date, setDate] = useState(now_date);
    const [time, setTime] = useState(now_time);


    const parcelId = props.match.params.id;
    const accessToken = localStorage.getItem('accessToken');

    const fetchParcel = () => {

        const response = axios.get(
            'http://localhost:8000/api/parcels/' + parcelId,
            {headers: {Authorization: 'Bearer ' + accessToken}}
        ).then(function (response) {
            setParcel(response.data);
        }).catch(function (err) {
            toast.error(err.response.data.message);
        });
    };

    const dateChangeHandler = (event) => {
        setDate(event.target.value);
    };

    const timeChangeHandler = (event) => {
        setTime(event.target.value);
    };

    const submitHandler = (event) => {

        event.preventDefault();

        let dateTime = Date.parse(date + ' ' + time);

        let timestamp = dateTime / 1000;

        axios.post(
            'http://localhost:8000/api/parcels/' + parcelId + '/deliver',
            {'delivery_date': timestamp},
            {headers: {Authorization: 'Bearer ' + accessToken}}
        )
            .then((response) => {
                toast(`Parcel ${parcel.code} delivered`);
                props.history.push('/biker-parcels');
            })
            .catch(function(err){
                toast.error(err.response.data.message);
            });
    };

    const cancelHandler = () => {
        props.history.push('/biker-parcels');
    };

    useEffect(() => {
        fetchParcel();
    }, []);

    return (
        <div className="bg-light min-vh-100 d-flex flex-row align-items-center">
            <CContainer>
                <CRow className="justify-content-center">
                    <CCol md={8}>
                        <CCardGroup>
                            <CCard className="p-4">
                                <CCardBody>
                                    <h1>Deliver Parcel #{parcel.code}</h1>
                                    <form onSubmit={submitHandler}>
                                        <div>
                                            <label>Date <span className="required-icon">*</span></label>
                                            <input type="date" value={date} onChange={dateChangeHandler} required />
                                        </div>
                                        <div>
                                            <label>Time <span className="required-icon">*</span></label>
                                            <input type="time" value={time} onChange={timeChangeHandler} required />
                                        </div>
                                        <div>
                                            <button type="submit" className="button bg-green">Deliver</button>
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
    );
};

export default DeliverParcel;