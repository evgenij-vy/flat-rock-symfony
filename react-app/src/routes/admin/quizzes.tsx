import React, {useEffect, useState} from "react";
import {getApiClient} from "../../controller/backEndApi";

const QuizzesForm = () => {
    const [quizzes, setData] = useState([]);
    const [quizEditBlockHidden, setQuizEditBlockHidden] = useState(true);
    const [quiz, setQuiz] = useState({id: '', title: '', active: false});

    const getQuestions = () => {
        return (
            <div>tttttttt</div>
        );
    }

    const updateAllQuiz = () => {
        getApiClient()
            .get('/quizzes')
            .then((response) => setData(response.data['hydra:member']));
    }

    const openCreateForm = () => {
        setQuiz({id: '', title: '', active: false})
        setQuizEditBlockHidden(false);
    }

    const openEditForm = (event: React.MouseEvent<HTMLElement>) => {
        event.preventDefault();
        getApiClient()
            .get(event.currentTarget.accessKey)
            .then((response) => {
                console.log(response.data['@id']);
                setQuiz({id: response.data['@id'], title: response.data.title, active: response.data.active})
            });
        setQuizEditBlockHidden(false);
    }

    const sendQuizToServer = (event: React.SyntheticEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (quiz.id) {
            getApiClient()
                .patch(quiz.id, {title: quiz.title, active: quiz.active})
                .then(() => updateAllQuiz());
        } else {
            getApiClient()
                .post('/quizzes', quiz)
                .then(() => updateAllQuiz());
        }
        setQuizEditBlockHidden(true);
        setQuiz({id: '', title: '', active: false});
    }

    const quizChangeHandler = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.name == 'active') {
            setQuiz({...quiz, [e.target.name]: !quiz.active});
        } else {
            setQuiz({...quiz, [e.target.name]: e.target.value});
        }
    }

    useEffect(() => {updateAllQuiz()},[]);

    return (
        <>
            <button onClick={openCreateForm}>Create</button>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    {quizzes.map((quiz) => (
                        <tr onClick={openEditForm} accessKey={quiz['@id']}>
                            <td>{quiz['title']}</td>
                            <td>{quiz['active'] ? 'yes' : 'no'}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <div hidden={quizEditBlockHidden}>
                <form onSubmit={sendQuizToServer}>
                    <input onChange={quizChangeHandler} type="text" name="title" value={quiz.title} required/>
                    <input type="checkbox" name="active" checked={quiz.active} onChange={quizChangeHandler}/>
                    <input value={quiz.id} hidden/>
                    {getQuestions()}
                    <button type="submit">{quiz.id ? "Edit" : "Create"}</button>
                    <div onClick={() => {
                        setQuizEditBlockHidden(true);
                        setQuiz({id: '', title: '', active: false});
                    }}>Close</div>
                </form>
            </div>
        </>
    );
}

export default QuizzesForm;