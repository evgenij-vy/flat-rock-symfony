import {getApiClient} from "../controller/backEndApi";

async function getData(){
    let data;

    await getApiClient().get(
        '/my_profile'
    ).then(function (response) {
        return response.data;
        })
        .then(function (responseData) {
            data = responseData;
    });

    return data;
}

const AccountForm = () => {
    const data = getData();

    return (
        <>
            <div>
            </div>
        </>
    );
}

export default AccountForm;