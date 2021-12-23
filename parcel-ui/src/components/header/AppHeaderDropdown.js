import React from 'react'
import {
    CAvatar,
    CDropdown,
    CDropdownDivider,
    CDropdownHeader,
    CDropdownItem,
    CDropdownMenu,
    CDropdownToggle,
} from '@coreui/react'
import {
    cilLockLocked,
    cilUser,
} from '@coreui/icons'
import CIcon from '@coreui/icons-react'
import axios from "axios";

import avatar8 from './../../assets/images/avatars/9.jpg'

import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const AppHeaderDropdown = (props) => {

    const logout = () => {

        const accessToken = localStorage.getItem('accessToken');

        if (!accessToken) {
            return null;
        }

        axios.get('http://localhost:8000/api/auth/logout', {headers: {Authorization: 'Bearer ' + accessToken}})
            .then((response) => {

                localStorage.removeItem('accessToken');
                localStorage.removeItem('role');

                props.history.push('/login')
            })
            .catch(function(err){
                toast.error("Logout failed");
            });
    };

    return (
        <CDropdown variant="nav-item">
            <CDropdownToggle placement="bottom-end" className="py-0" caret={false}>
                <CAvatar src={avatar8} size="md" />
            </CDropdownToggle>
            <CDropdownMenu className="pt-0" placement="bottom-end">
                <CDropdownHeader className="bg-light fw-semibold py-2">Account</CDropdownHeader>
                <CDropdownItem href="#" onClick={logout}>
                    <CIcon icon={cilLockLocked} className="me-2"/>
                    Logout
                    <ToastContainer/>
                </CDropdownItem>
            </CDropdownMenu>
        </CDropdown>
    )
}

export default AppHeaderDropdown
