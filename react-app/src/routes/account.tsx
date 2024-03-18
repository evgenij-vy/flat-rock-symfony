import {useEffect, useState} from "react";
import {getApiClient} from "../controller/backEndApi";
import {Simulate} from "react-dom/test-utils";
import error = Simulate.error;

const AccountForm = () => {
    const [userData, setUserData] = useState({
        email: '',
        firstName: '',
        lastName: ''
    });

    useEffect(() => {
        getApiClient()
            .get('/my_profile')
            .then((response) => {
                setUserData(response.data);
            })
    }, []);

    return (
        <>
            <div>
                <p>email: {userData.email}</p>
                <p>first name: {userData.firstName}</p>
                <p>last name: {userData.lastName}</p>
            </div>
        </>
    );
}

export default AccountForm;