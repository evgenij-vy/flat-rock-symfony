import React, { useState } from 'react';
import {getApiClient} from "../controller/backEndApi";
import {useNavigate} from "react-router-dom";

const RegisterForm = () => {
    const navigate = useNavigate();

    const [formData, setFormData] = useState({
        email: '',
        password: '',
        repeatPassword: '',
        firstName: '',
        lastName: null
    });

    const handleChange = (event: React.FormEvent<HTMLInputElement>) => {
        setFormData({
            ...formData,
            [event.currentTarget.name]: event.currentTarget.value
        })
    }

    const handleSubmit = (event: React.SyntheticEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (formData.password !== formData.repeatPassword) {
            alert('Repeat password wrong');
            return;
        }

        getApiClient().post(
            '/users/registration',
            formData
        )
            .catch(function (error) {
                alert(error.response.data.detail)
                return;
            })
            .then(function (response){
                navigate('/login');
            })
    }

    return (
        <form onSubmit={handleSubmit}>
            <input
                type="text"
                name="firstName"
                value={formData.firstName}
                placeholder="First name"
                onChange={handleChange}
                required
            />
            <input
                type="text"
                name="lastName"
                value={formData.lastName ?? ''}
                onChange={handleChange}
                placeholder="Last name"
            />
            <input
                type="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                placeholder="Email"
                required
            />
            <input
                type="password"
                name="password"
                value={formData.password}
                onChange={handleChange}
                placeholder="Password"
                required
            />
            <input
                type="password"
                name="repeatPassword"
                value={formData.repeatPassword}
                onChange={handleChange}
                placeholder="Repeat Password"
                required
            />
            <button type="submit">Register</button>
        </form>
    );
}

export default RegisterForm;