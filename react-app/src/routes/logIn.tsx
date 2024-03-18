import React, {useState} from "react";
import {getApiClient} from "../controller/backEndApi";

const LogInForm = () => {
    const [formData, setFormData] = useState(
        {
            email: '',
            password: ''
        }
    );

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (event: React.SyntheticEvent<HTMLFormElement>) => {
        event.preventDefault();

        getApiClient(false).
        post(
            '/auth',
            formData
        ).then(function (response) {
            localStorage.setItem('jwtToken', response.data.token);

            });
    }

    return (
        <form onSubmit={handleSubmit}>
            <input type="email" name="email" value={formData.email} onChange={handleChange} />
            <input type="password" name="password" value={formData.password} onChange={handleChange} />
            <button type="submit">Log In</button>
        </form>
    );
}

export default LogInForm;