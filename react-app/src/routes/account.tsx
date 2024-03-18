import {useEffect, useState} from "react";
import {getApiClient} from "../controller/backEndApi";

const AccountForm = () => {
    const [userData, setUserData] = useState({
        email: '',
        firstName: '',
        lastName: ''
    });

    useEffect(() => {
        getApiClient()
            .get('/my_profile')
            .then(function (response) {
                setUserData(response.data);
            });
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