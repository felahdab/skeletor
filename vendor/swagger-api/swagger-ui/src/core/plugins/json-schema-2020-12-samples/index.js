/**
 * @prettier
 */
import {
  sampleFromSchema,
  sampleFromSchemaGeneric,
  createXMLExample,
  memoizedSampleFromSchema,
  memoizedCreateXMLExample,
  encoderAPI,
  mediaTypeAPI,
  formatAPI,
  mergeJsonSchema,
} from "./fn/index"
import makeGetJsonSampleSchema from "./fn/get-json-sample-schema"
import makeGetYamlSampleSchema from "./fn/get-yaml-sample-schema"
import makeGetXmlSampleSchema from "./fn/get-xml-sample-schema"
import makeGetSampleSchema from "./fn/get-sample-schema"

const JSONSchema202012SamplesPlugin = ({ getSystem }) => {
  const getJsonSampleSchema = makeGetJsonSampleSchema(getSystem)
  const getYamlSampleSchema = makeGetYamlSampleSchema(getSystem)
  const getXmlSampleSchema = makeGetXmlSampleSchema(getSystem)
  const getSampleSchema = makeGetSampleSchema(getSystem)

  return {
    fn: {
      jsonSchema202012: {
        sampleFromSchema,
        sampleFromSchemaGeneric,
        sampleEncoderAPI: encoderAPI,
        sampleFormatAPI: formatAPI,
        sampleMediaTypeAPI: mediaTypeAPI,
        createXMLExample,
        memoizedSampleFromSchema,
        memoizedCreateXMLExample,
        getJsonSampleSchema,
        getYamlSampleSchema,
        getXmlSampleSchema,
        getSampleSchema,
        mergeJsonSchema,
      },
    },
  }
}

export default JSONSchema202012SamplesPlugin
