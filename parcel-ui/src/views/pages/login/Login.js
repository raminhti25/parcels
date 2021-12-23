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

const Login = (props) => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [role, setRole] = useState('sender');

    const emailChangeHandler = (event) => {
        setEmail(event.target.value);
    };

    const passwordChangeHandler = (event) => {
        setPassword(event.target.value);
    };

    const roleChangeHandler = (event) => {
        setRole(event.target.value);
    };

    const submitHandler = (event) => {

        event.preventDefault();

        axios.post('http://localhost:8000/api/auth/login', {'email': email, 'password': password, 'role': role})
            .then((response) => {

                localStorage.setItem('accessToken', (response.data.data.token));

                localStorage.setItem('role', role)

                if (role == 'sender') {
                    props.history.push('/sender-parcels')
                } else {
                    props.history.push('/biker-parcels')
                }
            })
            .catch(function(err){
                toast.error("Incorrect credentials");
            });
    };

    return (
        <div className="bg-light min-vh-100 d-flex flex-row align-items-center">
            <CContainer>
                <CRow className="justify-content-center">
                    <CCol md={8}>
                        <CCardGroup>
                            <CCard className="p-4">
                                <CCardBody>
                                    <form onSubmit={submitHandler}>
                                        <h1>Login</h1>
                                        <div>
                                            <label>Email:</label>
                                            <input type="text" name="email" value={email} style={inputStyle} onChange={emailChangeHandler} required/>
                                        </div>
                                        <div>
                                            <label>Password:</label>
                                            <input type="password" name="password" value={password} style={inputStyle} onChange={passwordChangeHandler} required/>
                                        </div>
                                        <div>
                                            <label>As:</label>
                                            <select name="role" value={role} style={inputStyle} onChange={roleChangeHandler}>
                                                <option value="sender">Sender</option>
                                                <option value="biker">Biker</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button style={submitStyle} type="submit">Submit</button>
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

const inputStyle = {
    margin: '5px 0 10px 0',
    padding: '5px',
    border: '1px solid #bfbfbf',
    borderRadius: '3px',
    boxSizing: 'border-box',
    width: '100%'
};

const submitStyle = {
    margin: '10px 0 0 0',
    padding: '7px 10px',
    border: '1px solid #efffff',
    borderRadius: '3px',
    background: '#3085d6',
    width: '100%',
    fontSize: '15px',
    color: 'white',
    display: 'block'
};

export default Login
