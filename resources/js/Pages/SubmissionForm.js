import React, { useState } from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link } from '@inertiajs/inertia-react';
import { Button } from '@chakra-ui/button';
import { Box, Grid, GridItem, HStack, Wrap } from '@chakra-ui/layout';
import { ArrowLeftIcon, ArrowRightIcon } from '@chakra-ui/icons';
import Uploader from '@/Components/Uploader';
import Step from '@/Components/Step';
import { FormControl, FormHelperText, FormLabel } from '@chakra-ui/form-control';
import { Input } from '@chakra-ui/input';

export default function SubmissionForm(props) {
    const { questions, period, steps } = props;

    const [page, setPage] = useState(1);
    const [tabs, setTabs] = useState(steps)

    const handleOnChangePage = (page) => {
        const modifiedTabs = tabs.map((tab) => ({
            ...tab,
            active: (tab.id === page)
        }))
        setTabs(modifiedTabs);
        setPage(page);
    }

    const inputs = questions[page];
    const lastKey = parseInt(Object.keys(questions).pop(), 10);
    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Submission Form</h2>}
        >
            <Head title="Submission Form" />
            <Step items={tabs} />
            <div className="hidden sm:block" aria-hidden="true">
                <div className="py-5">
                    <div className="border-t border-gray-200"></div>
                </div>
            </div>
            <div className="grid gap-4 w-3/4 m-auto pt-5">
                <div className="md:grid md:grid-cols-3 md:gap-6">
                    <div className="md:col-span-1">
                        <div className="px-4 sm:px-0">
                            <h3 className="text-lg font-bold leading-6 text-gray-900">Complete 3/6</h3>
                            <p className="mt-1 text-sm text-gray-600">
                                This information will be displayed privately so don't be worried what you share, you're save :).
                            </p>
                        </div>
                    </div>
                    <div className="mt-5 md:mt-0 md:col-span-2">
                        <form>
                            <div className="shadow sm:rounded-md sm:overflow-hidden">
                                <div className="px-4 py-5 bg-white space-y-6 sm:p-6">

                                    {inputs && inputs.map((input) => (
                                        <HStack w="full" key={input.id}>
                                            <Box w="70%">
                                                {input.label}
                                            </Box>
                                            <Box w="30%">
                                                <FormControl>
                                                    <Input type="number" />
                                                </FormControl>
                                            </Box>
                                        </HStack>
                                    ))}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            Upload Evidence
                                        </label>
                                        <Uploader />
                                    </div>
                                </div>
                                <div className="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <Grid templateColumns="repeat(5, 1fr)" gap={4}>
                                        <GridItem colSpan={2} h="10" >
                                            <Wrap align="left">
                                                <Button
                                                    variant="ghost"
                                                    disabled={page === 1}
                                                    leftIcon={<ArrowLeftIcon />}
                                                    onClick={() => handleOnChangePage(page - 1)}>
                                                    Previous
                                                </Button>
                                            </Wrap>
                                        </GridItem>
                                        <GridItem colStart={4} colEnd={6} h="10">
                                            <Button
                                                variant="ghost"
                                                disabled={lastKey === page}
                                                rightIcon={<ArrowRightIcon />}
                                                onClick={() => handleOnChangePage(page + 1)}>
                                                Next
                                            </Button>
                                        </GridItem>
                                    </Grid>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div >
        </Authenticated >
    );
}
