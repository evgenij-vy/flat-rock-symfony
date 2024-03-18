export type QuizQuestion = {
    id: string,
    question: string,
    answerType: string,
    active: boolean,
    quiz: string
    correctAnswer: string,
    quizQuestionAnswerVariants: []
}

export function getQuizQuestion() {
    return {
        id: '',
        question: '',
        answerType: '',
        active: false,
        quiz: '',
        correctAnswer: '',
        quizQuestionAnswerVariants: []
    };
}