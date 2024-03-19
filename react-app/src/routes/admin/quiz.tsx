import {useParams} from "react-router-dom";
import React, {useEffect, useState} from "react";
import {getQuizQuestion, QuizQuestion} from "../../types/QuizQuestion";
import {getApiClient} from "../../controller/backEndApi";

async function getQuizQuestions(quizId: string) {
    const quizQuestions = await getApiClient().get('/quizzes/' + quizId + '/questions');
    return quizQuestions.data['hydra:member'] ?? [];
}

const QuizForm = () => {
    const quizId = useParams().id ?? '';
    const [quizObject, setQuizData] = useState({
        '@id': '',
        id: '',
        title: '',
        active: false,
        questions: []
    })
    const [hiddenCreateQuestionBlock, setHiddenCreateQuestionBlock] = useState(true);
    const [questionData, setQuestionData] = useState(getQuizQuestion())

    useEffect(() => {
        const fetchData = async () => {
            const quizData = await getApiClient().get('/quizzes/' + quizId);
            const quizQuestions = await getQuizQuestions(quizId);
            setQuizData({
                ...quizObject,
                '@id': quizData.data['@id'],
                id: quizData.data.id,
                title: quizData.data.title,
                active: quizData.data.active,
                questions: quizQuestions
            });
        };

        fetchData();
    }, []);

    const createQuestion = () => {
        getApiClient()
            .post('/quiz_questions', {
                quiz: quizObject['@id'],
                question: questionData.question,
                answerType: questionData.answerType,
                active: questionData.active
            }).then(() => {
                setHiddenCreateQuestionBlock(true);
                getQuizQuestions(quizId).then((questions) => setQuizData({...quizObject, questions: questions}));
                setQuestionData(getQuizQuestion);
            }
        )
    }

    return (
        <>
            Title: <input type="text" value={quizObject.title}/>
            Active: <input type="checkbox" checked={quizObject.active}/><br/>
            Questions:
            <button type="submit" onClick={() => setHiddenCreateQuestionBlock(false)}>Create</button>
            {(quizObject.questions ?? []).map(
                (question: QuizQuestion) => {
                    return (
                        <>
                            <div>{question.question}</div>
                        </>
                    );
                }
            )}

            <div hidden={hiddenCreateQuestionBlock}>
                Question:<input
                    value={questionData.question}
                    onChange={(event) => setQuestionData({...questionData, question: event.target.value})}
                />
                Type:<select
                    value={questionData.answerType}
                    onChange={(event) => setQuestionData({...questionData, answerType: event.target.value})}
                >
                <option value='binary'>Binary</option>
                <option value='multiple'>Multiple choice</option>
                </select>
                Active: <input
                    type='checkbox'
                    checked={questionData.active}
                    onChange={() => setQuestionData({...questionData, active: !questionData.active})}
                />
                Answers:
                <button onClick={createQuestion}>Save</button>
                <button onClick={() => setHiddenCreateQuestionBlock(true)}>Close</button>
            </div>
        </>
    );
}

export default QuizForm;