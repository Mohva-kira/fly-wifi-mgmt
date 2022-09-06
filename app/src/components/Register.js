import React, { useState, useEffect } from 'react'
import { Formik, Form, Field, ErrorMessage } from 'formik'
import * as Yup from "yup"
import registerImg from "../assets/register.png"
import { useDispatch, useSelector } from 'react-redux'
import { useAddUserMutation } from '../slices/auth'
import { useNavigate } from 'react-router-dom'
import './register.css'


const Register = () => {
    const [successful, setSuccessful] = useState(false)
    const {message} = useSelector(state => state.message)
    const dispatch = useDispatch()
    const [registerUser] = useAddUserMutation()
    const navigate = useNavigate()
    useEffect(() => {
        // dispatch(clearMessage())
    }, [dispatch])

    const initialValues = {
        mobile: "",
    }

    const validationSchema = Yup.object().shape({
        mobile: Yup.string()
            .test("len",
                "The first name must be between 3 and 20 characters. ",
                (val) => val &&
                    val.toString().length >= 3 &&
                    val.toString().length <= 20
            )
            .required("This field is required!"),


    })

    const handleRegister = (formValue) => {
        const { username, mobile, password } = formValue
        console.log('yup')

        setSuccessful(false)
        registerUser({ username, mobile, password })
            .unwrap()
            .catch((e) => { console.log(e)
                setSuccessful(false) })
            
            console.log('ouii')
                setSuccessful(true)
                
                navigate(`/login`, {state: {mobile: mobile}})
           
    }
    return (
        <div className="col-md-12 login-form" >
            <Formik 
                initialValues={initialValues}
                validationSchema={validationSchema}
                onSubmit={handleRegister}    >
                <Form>
                    {!successful && (
                        <div>
                            <section className="vh-100">
                                <div className="container py-5 h-100">
                                <h1> </h1>
                                <>{console.log('yahhh')}</>
                                    <div className="row d-flex align-items-center justify-content-center h-100">
                                           
                                        <div className="col-md-8 col-lg-7 col-xl-6">
                                     
                                            <img src={registerImg}
                                                className="img-fluid" alt="Phone image" />
                                        </div>
                                        <div className="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                                       

                                                <div className="form-outline mb-4">
                                                    <Field type="number" inputMode='numeric' pattern="[0-9]*" id="mobile" name="mobile" className="form-control form-control-lg" />
                                                    <label className="form-label" htmlFor="mobile">Mobile Number</label>
                                                    <ErrorMessage name="mobile" component="div" className=" alert alert-danger"/>
                                                </div>

                                                {/* <div className="d-flex justify-content-around align-items-center mb-4">

                                                    <div className="form-check">
                                                        <input className="form-check-input" type="checkbox" value="" id="form1Example3" defaultChecked />
                                                        <label className="form-check-label" htmlFor="form1Example3"> Remember me </label>
                                                    </div>
                                                    <a href="#!">Forgot password?</a>
                                                </div> */}


                                                <button type="submit" className="btn btn-primary btn-lg w-100 m-2 p-2">Sign in</button>

                                             

                                              

                                        
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    )

                    }
                </Form>
            </Formik>

        </div>
    )
}

export default Register