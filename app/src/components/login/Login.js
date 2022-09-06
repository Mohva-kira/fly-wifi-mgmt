import React, { useState, useEffect } from 'react'
import { Formik, Form, Field, ErrorMessage } from 'formik'
import * as Yup from "yup"
import { useDispatch, useSelector } from 'react-redux'
import { useLoginMutation } from '../../slices/auth'
import { useLocation, useNavigate } from 'react-router-dom'
import './login.css'
const Login = ({ route }) => {
    const location = useLocation()
    const [successful, setSuccessful] = useState(false)
    const { message } = useSelector(state => state.message)
    const dispatch = useDispatch()
    const [login, { isLoading }] = useLoginMutation()
    const navigate = useNavigate()
    useEffect(() => {
        //  dispatch(clearMessage())
    }, [dispatch])

    const initialValues = {
        otp:""
    }

    const validationSchema = Yup.object().shape({
        otp: Yup.string()
            .test("len",
                "The first name must be between 3 and 20 characters. ",
                (val) => val &&
                    val.toString().length >= 5 &&
                    val.toString().length <= 5
            )
            .required("This field is required!"),


    })

    const handleLogin = (formValue) => {
        console.log('yup')
        const {otp}  = formValue
        const mobile = location.state.mobile

        setSuccessful(false)
        try {
            login({ mobile, otp })
                .unwrap()
              
                navigate('/dashboard')
            setSuccessful(true)
        } catch (err) {
            console.log({
                status: 'error',
                title: 'Error',
                description: 'Oh no, there was an error!',
                isClosable: true,
            })
        }





    }
    return (
        <div className="col-md-12 login-form" >
            <Formik
                initialValues={initialValues}
                validationSchema={validationSchema}
                onSubmit={handleLogin}    >
                <Form>
                    {!successful && (
                        <div>
                            {location.state.mobile}
                            <section className="vh-100">
                                <div className="container py-5 h-100">
                                    <div className="row d-flex align-items-center justify-content-center h-100">
                                        <div className="col-md-8 col-lg-7 col-xl-6">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                                                className="img-fluid" alt="Phone image" />
                                        </div>
                                        <div className="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

                                            <div className="form-outline mb-4">
                                                <Field type="number" inputMode='numeric' pattern="[0-9]*" id="otp" name="otp" className="form-control form-control-lg" />
                                                <label className="form-label" htmlFor="otp">Fill the code sent by sms</label>
                                                <ErrorMessage name="otp" component="div" className=" alert alert-danger" />
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

export default Login